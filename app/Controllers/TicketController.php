<?php

namespace App\Controllers;
use App\Models\StationModel;
use App\Models\RouteModel;
use App\Models\RoutetariffModel;
use App\Models\TrainModel;
use App\Models\UserModel;
use App\Models\TicketModel;

class TicketController extends BaseController
{
    private $StationModel;
    private $TrainModel;
    private $RouteModel;
    private $TicketModel;
    private $TariffModel;
    private $UserModel;

    public function __construct(){
        $this->StationModel = new StationModel();
        $this->RouteModel = new RouteModel();
        $this->TrainModel = new TrainModel();
        $this->TariffModel = new RoutetariffModel();
        $this->UserModel = new UserModel();
        $this->TicketModel = new TicketModel();
    }

    public function index(){
        $data['stations'] = $this->StationModel->findAll();
        $header['head_title'] = "Book Ticket";    
        if ($this->request->getPost()) {
            $fromStation = $this->request->getVar('start_point');
            $toStation = $this->request->getVar('end_point');
            $travelDate = $this->request->getVar('travel_date');
            if ($fromStation && $toStation && $travelDate) {
                $dayOfWeek = date('N', strtotime($travelDate));    
                $bookingResults = $this->TariffModel->getBookings($fromStation, $toStation);
                $bookings = [];
                foreach ($bookingResults as $i => $result) {
                    if (empty($result['route_km'])) {
                        continue;
                    }
                    $routeData = getRouteData($result['route_id']);
                    $trainData = train_details($routeData['route_train']);
                    $availableDays = explode(',', $routeData['avl_days']);
                    if (in_array($dayOfWeek, $availableDays)) {
                        $bookings[$i]['routeData'] = $routeData;
                        $bookings[$i]['trainData'] = $trainData;
                        $bookings[$i]['tariff_data'] = $result;
                    }
                }    
                if (!empty($bookings)) {
                    $data['results'] = [
                        'from_station' => $fromStation,
                        'to_station' => $toStation,
                        'travel_date' => $travelDate,
                        'booking_options' => $bookings,
                    ];
                } else {
                    $data['error'] = 'No available routes match the selected travel date.';
                }
            } else {
                $data['error'] = 'Please fill in all fields.';
            }
            $data['submitted_data'] = [
                'route_start' => $fromStation,
                'route_end' => $toStation,
                'travel_date' => $travelDate,
            ];
        }
        echo view('header', $header);
        echo view('Ticket/book_ticket', $data);
        echo view('footer');
    }

    public function book_ticket(){
        $passenger_name = $this->request->getVar('passenger_name');
        $passenger_email = $this->request->getVar('passenger_email');
        $passenger_phone = $this->request->getVar('passenger_phone');
        $passenger_age = $this->request->getVar('passenger_age');
        $from_station = $this->request->getVar('from_station_id');
        $to_station = $this->request->getVar('to_station_id');
        $coach_type = $this->request->getVar('coach_type');
        $ticket_date = $this->request->getVar('ticket_date');
        $ticket_price = $this->request->getVar('ticket_price');
        $train_name = $this->request->getVar('train_name');
        $session = session();
        $user_id = $session->get('user_id');
        $data = [
            'passenger_name' => $passenger_name,
            'passenger_email' => $passenger_email,
            'passenger_phone' => $passenger_phone,
            'train_name' => $train_name,
            'to_station' => $to_station,
            'from_station' => $from_station,
            'passenger_age' => $passenger_age,
            'selected_coach' => $coach_type,
            'ticket_date' => $ticket_date,
            'ticket_price' => $ticket_price,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $user_id
        ];
        $this->TicketModel->insert($data);
        $successMsg = 'Your ticket booked  successfully, Thank you in advance for traveling with SRCTC.';
        return redirect()->to('getTickets')->with('success', $successMsg);    
    }
    
    public function check_availability(){
        $coach = $this->request->getVar('coach');
        $from_station = $this->request->getVar('from_station');
        $to_station = $this->request->getVar('to_station');
        $travel_date = $this->request->getVar('travel_date');
        $bookedCount = $this->TicketModel->countBookedTickets($from_station, $to_station, $coach, $travel_date);
        $maxAvailability = 72;
        $remainingAvailability = $maxAvailability - $bookedCount;
        $remainingAvailability = max(0, $remainingAvailability);
        return $this->response->setJSON([
            'success' => true,
            'availability' => $remainingAvailability
        ]);
    }

    public function getTickets(){
        $session = session();
        $id = $session->get('user_id');
        $user = user_data($id);
        if($user['user_type'] == 10 || $user['user_type'] == 20){
            $header['head_title'] = "Tickets List";
        }else{
            $header['head_title'] = "My Bookings";
        }
        $header['header_scripts'] = [
            'public/js/dataTables/js/dataTables.min.js',
            'public/js/dataTables/js/jquery.dataTables.min.js',
            'public/js/dataTables/css/jquery.dataTables.min.css',
        ];
        echo view('header', $header);
        echo view('Ticket/ticket_list');
        echo view('footer');
    }

    public function ticket_list_ajax() {
        $tickets = $this->TicketModel->findAll();   
        foreach ($tickets as &$ticket) {
            $train = train_details($ticket['train_name']);
            $ticket['train_names'] = $train['train_code'] . ' - ' . $train['train_name'];
            $ticket['from'] = getStation($ticket['from_station']);
            $ticket['to'] = getStation($ticket['to_station']);
            $ticket['coach'] = getCoaches($ticket['selected_coach']);
        }
        return $this->response->setJSON($tickets);
    }   

    public function fetchContent($tabName) {
        $session = session();
        $user_id = $session->get('user_id');
        $currentDateTime = date('Y-m-d');    
        if (!$user_id) {
            echo "User not authenticated.";
            return;
        }
        switch ($tabName) {
            case 'tab1':
                $data = $this->TicketModel->where('created_by', $user_id)->findAll();
                break;
            case 'tab2':
                $data = $this->TicketModel->where('created_by', $user_id)->where('ticket_date >=', $currentDateTime)->findAll();
                break;
            case 'tab3':
                $data = $this->TicketModel->where('created_by', $user_id)->where('ticket_date <', $currentDateTime)->findAll();
                break;
            default:
                $data = [];
        }
        echo view('Ticket/ticket_content', ['data' => $data]);
    }

    public function getTicketData($filter = 'today')
    {
        $today = date('Y-m-d');
        $start_date = $today;
        $end_date = $today;
        switch ($filter) {
            case 'today':
                $start_date = $today;
                $end_date = $today;
                break;
            case 'month':
                $start_date = date('Y-m-01');
                $end_date = date('Y-m-t');
                break;
            case 'year':
                $start_date = date('Y-01-01');
                $end_date = date('Y-12-31');
                break;
        }
        $totalTickets = $this->TicketModel->getTotalTicketsByDateRange($start_date, $end_date);
        $data = [
            'total_tickets' => $totalTickets
        ];
        return $this->response->setJSON($data);
    }

    public function getRevenueData($filter = 'today')
    {
        $today = date('Y-m-d');
        $start_date = $today;
        $end_date = $today;
        switch ($filter) {
            case 'today':
                $start_date = $today;
                $end_date = $today;
                break;
            case 'month':
                $start_date = date('Y-m-01');
                $end_date = date('Y-m-t');
                break;
            case 'year':
                $start_date = date('Y-01-01');
                $end_date = date('Y-12-31');
                break;
        }
        $totalRevenue = $this->TicketModel->getTotalRevenueByDateRange($start_date, $end_date);
        $data = [
            'total_revenue' => $totalRevenue,
        ];
        return $this->response->setJSON($data);
    }
    
    public function delete_ticket($id){
        $Ticket = $this->TicketModel->find($id);
        if (!$Ticket) {
            return redirect()->to('getTickets')->with('error', 'Ticket not found.');
        }
        $this->TicketModel->delete($id);
        return redirect()->to('getTickets')->with('success', 'Ticket deleted successfully.');
    }

    public function edit_ticket($id) {
        if ($this->request->getPost()) {
            $passenger_name = $this->request->getVar('passenger_name');
            $passenger_email = $this->request->getVar('passenger_email');
            $passenger_phone = $this->request->getVar('passenger_phone');
            $Data = [
                'passenger_name' => $passenger_name,
                'passenger_email' => $passenger_email,
                'passenger_phone' => $passenger_phone
            ];
            $this->TicketModel->update($id, $Data);
            return redirect()->to('getTickets')->with('success', 'Ticket updated successfully.');  
        } else {          
            $data['data'] = $this->TicketModel->find($id);            
            $header['head_title'] = "Update Ticket";
            echo view('header', $header);
            echo view('Ticket/edit_ticket', $data);
            echo view('footer');   
        }
    }  
}