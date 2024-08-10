<?php
namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table = 'srctc_ticket';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'passenger_name', 'passenger_email', 'passenger_phone', 'passenger_age', 
        'train_name', 'from_station', 'to_station', 'selected_coach', 'ticket_date', 
        'ticket_status', 'ticket_price', 'created_at', 'created_by'
    ];

    public function countBookedTickets($fromStation, $toStation, $coach, $travelDate)
    {
        return $this->where('from_station', trim($fromStation))
                    ->where('to_station', trim($toStation))
                    ->where('selected_coach', trim($coach))
                    ->where('ticket_date', $travelDate)
                    ->countAllResults();
    }

    public function getDataBasedOnFilter($filter)
    {
        $builder = $this->builder();
        $data = [];

        if ($filter === 'week') {
            $startOfWeek = date("Y-m-d", strtotime('monday this week'));
            $endOfWeek = date("Y-m-d", strtotime('sunday this week'));

            $builder->select('DAYNAME(created_at) as day, COUNT(*) as count')
                    ->where("created_at BETWEEN '$startOfWeek' AND '$endOfWeek'")
                    ->groupBy('day')
                    ->orderBy('FIELD(day, "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday")');

            $query = $builder->get();
            $result = $query->getResultArray();

            $labels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $counts = array_fill(0, 7, 0);

            foreach ($result as $row) {
                $index = array_search($row['day'], $labels);
                if ($index !== false) {
                    $counts[$index] = $row['count'];
                }
            }

            $data = [
                'labels' => $labels,
                'counts' => $counts
            ];
        } elseif ($filter === 'month') {
            $currentMonth = date("Y-m");

            $builder->select('DAY(created_at) as day, COUNT(*) as count')
                    ->where("DATE_FORMAT(created_at, '%Y-%m') = '$currentMonth'")
                    ->groupBy('day')
                    ->orderBy('day');

            $query = $builder->get();
            $result = $query->getResultArray();

            $labels = range(1, date('t'));
            $counts = array_fill(0, count($labels), 0);

            foreach ($result as $row) {
                $day = intval($row['day']);
                $counts[$day - 1] = $row['count'];
            }

            $data = [
                'labels' => $labels,
                'counts' => $counts
            ];
        } elseif ($filter === 'year') {
            $currentYear = date("Y");
            $labels = [];
            $counts = [];

            for ($i = 1; $i <= 12; $i++) {
                $monthLabel = date("M", mktime(0, 0, 0, $i, 1));
                $labelWithYear = $monthLabel . ' ' . $currentYear;

                $builder->select('COUNT(*) as count')
                        ->where("YEAR(created_at) = '$currentYear' AND MONTH(created_at) = '$i'");

                $query = $builder->get();
                $row = $query->getRow();

                $labels[] = $labelWithYear;
                $counts[] = $row ? $row->count : 0;
            }

            $data = [
                'labels' => $labels,
                'counts' => $counts
            ];
        }

        return $data;
    }

    public function getTotalTicketsByDateRange($start_date, $end_date)
    {
        return $this->where('created_at >=', $start_date . ' 00:00:00')
                    ->where('created_at <=', $end_date . ' 23:59:59')
                    ->countAllResults();
    }


    public function getTotalRevenueByDateRange($start_date, $end_date)
    {
        return $this->selectSum('ticket_price')
                    ->where('created_at >=', $start_date . ' 00:00:00')
                    ->where('created_at <=', $end_date . ' 23:59:59')
                    ->first()['ticket_price'];
    }
}
