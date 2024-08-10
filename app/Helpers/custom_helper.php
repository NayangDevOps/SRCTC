<?php 
if (!function_exists('user_data')){
    function user_data($id){
        $model = new \App\Models\UserModel();
        return $model->getUserData($id);
    }
}
if (!function_exists('getRouteData')){
    function getRouteData($id){
        $model = new \App\Models\RouteModel();
        return $model->getRouteData($id);
    }
}
if (!function_exists('company_data')){
    function company_data(){
        $model = new \App\Models\CompanyModel();
        return $model->findAll();  
    }
}
if (!function_exists('train_details')){
    function train_details($id){
        $model = new \App\Models\TrainModel();
        return $model->getTrainData($id);
    }
}
if (!function_exists('getStation')){
    function getStation($id){
        $model = new \App\Models\StationModel();
        $data = $model->getStationData($id);
        return $data['station_name'];
    }
}
if (!function_exists('getRoute')){
    function getRoute($id){
        $model = new \App\Models\RouteModel();
        return $model->getRouteIdByTrainId($id);
    }
}
if (!function_exists('getTrainByRoute')){
    function getTrainByRoute($id){
        $model = new \App\Models\RouteModel();
        $rout_data = $model->getRouteData($id);
        $train_details = train_details($rout_data['route_train']);
        return $train_details['train_code'].' - '.$train_details['train_name'];
    }
}
if (!function_exists('formatRunsOnLabel')){
    function formatRunsOnLabel($avlDays){
        $daysMap = ['1' => 'M', '2' => 'T', '3' => 'W', '4' => 'T', '5' => 'F', '6' => 'S', '7' => 'S'];
        $avlDaysArray = explode(',', $avlDays);
        $runsOn = array_map(function($day) use ($daysMap) {
            return $daysMap[$day];
        }, $avlDaysArray);
        return implode(' ', $runsOn);
    }
}
if (!function_exists('getCoaches')) {
    function getCoaches($coach) {
        $coach_names = [
            '1' => 'AC 1 Tier(1A)',
            '2' => 'AC 2 Tier(2A)',
            '3' => 'AC 3 Tier(3A)',
            '4' => 'Economy(3E)',
            '5' => 'Sleeper(SL)',
        ];
        return $coach_names[$coach] ?? 'Unknown';
    }
}
?>