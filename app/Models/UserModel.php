<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'srctc_user_reg';
    protected $primaryKey = 'id';
    protected $allowedFields = ['first_name', 'last_name', 'display_name', 'email', 'mobile_no', 'profile_pic', 'gender', 'password', 'user_type', 'created_at'];

    public function getUserData($id){
        return $this->find($id);
    }

    public function countAllRecords(){
        return $this->countAll();
    }

    public function countUsersByType(){
        $builder = $this->builder();
        $builder->select('COUNT(*) as normal_users')
                ->groupStart()
                    ->where('user_type', NULL)
                    ->orWhere('user_type', 1)
                ->groupEnd();
        $query = $builder->get();
        $normalUsersCount = $query->getRow()->normal_users;
        $builder->select('COUNT(*) as admin_users')->where('user_type', 20);
        $query = $builder->get();
        $adminUsersCount = $query->getRow()->admin_users;
        $builder->select('COUNT(*) as super_admin')->where('user_type', 10);
        $query = $builder->get();
        $superAdminCount = $query->getRow()->super_admin;
        $builder->select('COUNT(*) as loco_pilot')->where('user_type', 30);
        $query = $builder->get();
        $loco_pilotcount = $query->getRow()->loco_pilot;    
        return [
            'normal_users' => $normalUsersCount,
            'admin_users' => $adminUsersCount,
            'super_admin' => $superAdminCount,
            'loco_pilot' => $loco_pilotcount
        ];
    }

    public function getDataBasedOnFilter($filter)
    {
        $builder = $this->builder();
        $data = [];

        if ($filter === 'week') {
            $startOfWeek = date("Y-m-d", strtotime('monday this week'));
            $endOfWeek = date("Y-m-d", strtotime('sunday this week'));

            $builder->select('DATE_FORMAT(created_at, "%W") as day, COUNT(*) as count')
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

            $builder->select('DATE_FORMAT(created_at, "%e") as day, COUNT(*) as count')
                ->where("DATE_FORMAT(created_at, '%Y-%m') = '$currentMonth'")
                ->groupBy('day')
                ->orderBy('day');

            $query = $builder->get();
            $result = $query->getResultArray();

            $labels = range(1, 31);
            $counts = array_fill(0, 31, 0);

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

                if ($row) {
                    $labels[] = $labelWithYear;
                    $counts[] = $row->count;
                } else {
                    $labels[] = $labelWithYear;
                    $counts[] = 0;
                }
            }

            $data = [
                'labels' => $labels,
                'counts' => $counts
            ];
        }

        return $data;
    }
    
}