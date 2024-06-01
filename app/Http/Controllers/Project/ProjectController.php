<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Plan\Depratment;
use App\Models\Plan\District;
use App\Models\Plan\Goal;
use App\Models\Plan\GoalCategory;
use App\Models\Plan\Unit;
use App\Models\Project\budgets;
use App\Models\Project\DepartmentActivity;
use App\Models\Project\Project;
use App\Models\Project\ProjectTracking;
use App\Models\Project\ReportProjectTracking;
use App\Models\Project\YearBudget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!(auth::user()->can('view_project') and Auth::user()->can('projects'))){
            return view('layouts.403');
        }

        if((auth::user()->can('show_all_projects'))){
            $project_trackings = false;
            $projects = Project::with('budgets','goal_category','units','impliment_departments','management_departments','design_departments')->orderByDesc('id')->get();
        }else{

            $project_trackings = ProjectTracking::with('project_projcts','project_departments')->where('department_id','=',auth::user()->department_id)->orderByDesc('id')->get();
            // dd($project_trackings);
            $projects = Project::with('goal_category','units','impliment_departments','management_departments','design_departments')->orderByDesc('id')->get();
        }
        return view('project.project', compact('projects','project_trackings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!(auth::user()->can('add_project') and auth::user()->can('projects'))){
            return view('layouts.403');
        }
        $goles = GoalCategory::get();
        $units = Unit::get();
        $depratments = Depratment::where('status','=','1')->get();
        $districts = District::get();

        return view('project.add_project',compact('goles','units','depratments','districts','districts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!(auth::user()->can('add_project') and auth::user()->can('projects'))){
            return view('layouts.403');
        }
        $request->validate([
            'name'                      => 'required|string|unique:projects',
            'number'                    => 'required_without_all:width,length_p',
            'width'                     => 'required_without_all:number',
            'length_p'                  => 'required_without_all:number',
            'unit_id'                   => 'required|exists:units,id',
            'goal_id'                   => 'required|exists:goal_categories,id',
            'impliment_department_id'   => 'required|exists:departments,id',
            'management_department_id'  => 'required|exists:departments,id',
            'design_department_id'      => 'required|exists:departments,id',
            'district_id'               => 'required|exists:districts,id',
            'main_budget'               => 'required|numeric|gte:for_this_year',
            'for_this_year'             => 'required|numeric|lte:main_budget',
        ]);
        // dd($request->all());

        // here we will insert product in db
        $project = new Project();
        $project->goal_id                      = $request->goal_id;
        $project->name                         = $request->name;
        $project->length                       = $request->length_p;
        $project->width                        = $request->width;
        $project->number                       = $request->number;
        $project->unit_id                      = $request->unit_id ;
        $project->impliment_department_id      = $request->impliment_department_id  ;
        $project->management_department_id     = $request->management_department_id   ;
        $project->design_department_id         = $request->design_department_id    ;
        $project->save();

        $project->districts()->sync($request->input('district_id'));

        $budget = new Budgets();
        $budget->project_id         = $project->id;
        $budget->main_budget        = $request->main_budget;
        $budget->save();


        $year_budget = new YearBudget();
        $year_budget->budget_id        = $budget->id;
        $year_budget->year             = Carbon::now()->format('Y-m-d');
        $year_budget->this_year_budget = $request->for_this_year;
        $year_budget->save();

        return redirect()->route('project.index')->with('success', 'پروژه جدید اضافه کردید.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::with('goal_category.goals','units','impliment_departments','management_departments','design_departments','budgets.year_budgets','project_trackings.project_departments','project_trackings.project_tracking_details.department_activities')->find($id);

        // $report_project_traccking = ProjectTracking::where('project')

        return view('project.details_project',compact('project'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(!(auth::user()->can('edit_project') and auth::user()->can('projects'))){
            return view('layouts.403');
        }
        $goals = GoalCategory::get();
        $units = Unit::get();
        $depratments = Depratment::where('status','=','1')->get();
        $districts = District::get();

        $project = Project::with('budgets')->find($id);

        return view('project.edit_project',compact('project','goals','units','depratments','districts','districts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!(auth::user()->can('edit_project') and auth::user()->can('projects'))){
            return view('layouts.403');
        }
        // dd($request);
        $request->validate([
            'name'                      => ['required','string',Rule::unique('projects')->ignore($id)],
            'number'                    => 'required_without_all:width,length_p',
            'width'                     => 'required_without_all:number',
            'length_p'                  => 'required_without_all:number',
            'unit_id'                   => 'required|exists:units,id',
            'goal_id'                   => 'required|exists:goal_categories,id',
            'impliment_department_id'   => 'required|exists:departments,id',
            'management_department_id'  => 'required|exists:departments,id',
            'design_department_id'      => 'required|exists:departments,id',
            'district_id'               => 'required|exists:districts,id',
            'main_budget'               => 'required|numeric|gte:for_this_year', # for_this_year بییشتر یا مساوی با
            'for_this_year'             => 'required|numeric|lte:main_budget',   # main_budget کمتر یا مساوی با
        ]);

        $update = Project::find($id);

        $update->update([
            'goal_id' => $request->goal_id,
            'name' => $request->name,
            'length' => $request->length_p,
            'width' => $request->width,
            'number' => $request->number,
            'unit_id' => $request->unit_id,
            'impliment_department_id' => $request->impliment_department_id,
            'management_department_id' => $request->management_department_id,
            'design_department_id' => $request->design_department_id,
        ]);

        $update->districts()->sync($request->input('district_id'));

        $budget = Budgets::where('project_id','=',$id)->first();

        if(!$budget == null){
            $budget->update([
                'main_budget' => $request->main_budget,
            ]);
            $year_budget = YearBudget::where('budget_id','=',$budget->id)->first();

            $year_budget->update([
                'this_year_budget' => $request->for_this_year,
            ]);
        }else{
            $budget = new budgets();
            $budget->project_id         = $id;
            $budget->main_budget        = $request->main_budget;
            $budget->save();


            $year_budget = new YearBudget();
            $year_budget->budget_id        = $budget->id;
            $year_budget->year             = Carbon::now()->format('Y-m-d');
            $year_budget->this_year_budget = $request->for_this_year;
            $year_budget->save();
        }

        return redirect()->route('project.index')->with('success', ' معلومات پروژه شما تصحیح شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!(auth::user()->can('delete_project') and auth::user()->can('projects'))){
            return view('layouts.403');
        }
        $delete = Project::find($id);

        $delete->delete();
        return redirect()->route('project.index')->with('warning', 'پروژه شما حذف گردید.');
    }

    public function export(){
        $file_name ="report-".Carbon::now()->format('Y-m-d ساعت-h');
        // dd($file_name);
        // where('id','=','35')->
        $projects = Project::with('goal_category.goals','budgets','units','impliment_departments','management_departments','design_departments','districts','project_trackings.project_tracking_details.department_activities')->orderByDesc('id')->get();
        // $projects->all();
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet()->setRightToLeft(true);

        // تنظیم استایل هدرها
        $header_styles = $activeWorksheet->getStyle('A1:AC8');
        $header_styles->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $header_styles->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $header_styles->getFont()->setBold(true);
        $header_styles->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
        $header_styles->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $header_styles->getFill()->getStartColor()->setARGB('FF4CAF50');
        $activeWorksheet->getStyle('A6:AC8')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        $year = '1403';

        // بخش هیدر اکسل
        $activeWorksheet->setCellValue('A1', 'دافغانستان اسلامی امارت')->mergeCells('A1:AC1');
        $activeWorksheet->setCellValue('A2', 'د کابل ښارولی')->mergeCells('A2:AC2');
        $activeWorksheet->setCellValue('A3', 'د پلان، پالیسی، څارنی او ارزونی ریاست')->mergeCells('A3:AC3');
        $activeWorksheet->setCellValue('A4', 'د پلان او پروژو جوړولو آمریت')->mergeCells('A4:AC4');
        $activeWorksheet->setCellValue('A5', 'پلان پروژه های انکشافی بودجه داخلی سال '.$year)->mergeCells('A5:AC5');
        $activeWorksheet->setCellValue('A6', 'شماره مسلسل')->mergeCells('A6:A8');
        $activeWorksheet->setCellValue('B6', 'برنامه')->mergeCells('B6:B8');
        $activeWorksheet->setCellValue('C6', 'برنامه')->mergeCells('C6:C8');
        $activeWorksheet->setCellValue('D6', 'اسم پروژه')->mergeCells('D6:D8');
        $activeWorksheet->setCellValue('E6', 'ابعاد')->mergeCells('E6:F6');
        $activeWorksheet->setCellValue('E7', 'طول')->mergeCells('E7:E8');
        $activeWorksheet->setCellValue('F7', 'عرض')->mergeCells('F7:F8');
        $activeWorksheet->setCellValue('G6', 'موقعیت')->mergeCells('G6:G8');
        $activeWorksheet->setCellValue('H6', 'تعهد بودجوی '.$year)->mergeCells('H6:H8');
        $activeWorksheet->setCellValue('I6', 'بودجه اختصاصی '.$year)->mergeCells('I6:J6');
        $activeWorksheet->setCellValue('I7', 'فیصدی')->mergeCells('I7:I8');
        $activeWorksheet->setCellValue('J7', 'مبلغ')->mergeCells('J7:J8');
        $activeWorksheet->setCellValue('K6', 'تطبیق کننده')->mergeCells('K6:K8');
        $activeWorksheet->setCellValue('L6', 'مدیریت کننده')->mergeCells('L6:L8');
        $activeWorksheet->setCellValue('M6', 'دیزاین کننده')->mergeCells('M6:M8');
        $activeWorksheet->setCellValue('N6', 'پروژه انتقالی / جدید')->mergeCells('N6:N8');
        $activeWorksheet->setCellValue('O6', 'ملاحظات')->mergeCells('O6:O8');
        $activeWorksheet->setCellValue('P6', 'فیصدی')->mergeCells('P6:S6');
        $activeWorksheet->setCellValue('P7', 'دیزاین')->mergeCells('P7:P8');
        $activeWorksheet->setCellValue('Q7', 'تدارکات')->mergeCells('Q7:R7');
        $activeWorksheet->setCellValue('Q8', 'تدارکات داخلی');
        $activeWorksheet->setCellValue('R8', 'تدارکات ملی');
        $activeWorksheet->setCellValue('S7', 'تطبیق')->mergeCells('S7:S8');
        $activeWorksheet->setCellValue('T6', 'وضعیت فعلی پروژه')->mergeCells('T6:T8');
        $activeWorksheet->setCellValue('U6', 'تاریخ تکمیل دیزاین')->mergeCells('U6:U8');
        $activeWorksheet->setCellValue('V6', 'تاریخ تکمیل پروسه تدارکات')->mergeCells('V6:V8');
        $activeWorksheet->setCellValue('W6', 'زمان بین تکمیل دیزاین و عقد قرار داد')->mergeCells('W6:W8');
        $activeWorksheet->setCellValue('X6', 'مدت عقد قرار داد')->mergeCells('X6:X8');
        $activeWorksheet->setCellValue('Y6', 'تاریخ احتمالی اختتام')->mergeCells('Y6:Y8');
        $activeWorksheet->setCellValue('Z6', 'مشکلات')->mergeCells('Z6:Z8');
        $activeWorksheet->setCellValue('AA6', ' دلایل تأخیر / عدم تطبیق')->mergeCells('AA6:AA8');
        $activeWorksheet->setCellValue('AB6', 'فعلاً پروژه در کدام ریاست است ؟ ')->mergeCells('AB6:AB8');
        $activeWorksheet->setCellValue('AC6', 'ملاحظات آمریت نظرت و ارزیابی')->mergeCells('AC6:AC8');

        $row_count = 9;

        // تنظیم استایل wrap text D برای ستون
        // $spreadsheet->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);
        $body_styles = $activeWorksheet->getStyle('A1:AC100');
        $body_styles->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $body_styles->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        foreach($projects as $key => $project){

            $percentage_design = ReportProjectTracking::where('report_project_tracking.project_id', $project->id)
                                                        ->where('report_project_tracking.department_id', $project->design_departments->first()->id)
                                                        ->where('report_project_tracking.reject_activity', null)
                                                        ->join('department_activities', 'department_activities.id', '=', 'report_project_tracking.department_activity_id')
                                                        ->sum('department_activities.acitvity_percentage');

            $percentage_impliment = ReportProjectTracking::where('report_project_tracking.project_id', $project->id)
                                                        ->where('report_project_tracking.department_id', $project->impliment_departments->first()->id)
                                                        ->where('report_project_tracking.reject_activity', null)
                                                        ->join('department_activities', 'department_activities.id', '=', 'report_project_tracking.department_activity_id')
                                                        ->sum('department_activities.acitvity_percentage');

            $district_names         = '';
            foreach($project->districts as $district){
                $district_names .= $district->name.',';
            }
            $activeWorksheet->setCellValue('A'.$row_count, $key+1);
            $activeWorksheet->setCellValue('B'.$row_count, $project->goal_category->first()->goals->first()->goal_name);
            $activeWorksheet->setCellValue('C'.$row_count, $project->goal_category->first()->name);
            $activeWorksheet->setCellValue('D'.$row_count, $project->name);
            $activeWorksheet->setCellValue('E'.$row_count, $project->length);
            $activeWorksheet->setCellValue('F'.$row_count, $project->width);
            $activeWorksheet->setCellValue('G'.$row_count, $district_names);
            $activeWorksheet->setCellValue('H'.$row_count, number_format($project->budgets->main_budget));
            $activeWorksheet->setCellValue('I'.$row_count, number_format(($project->budgets->year_budgets()->orderByDesc('id')->first()->this_year_budget * 100) / $project->budgets->main_budget).'%');
            $activeWorksheet->setCellValue('J'.$row_count, number_format($project->budgets->year_budgets()->orderByDesc('id')->first()->this_year_budget));
            $activeWorksheet->setCellValue('K'.$row_count, $project->impliment_departments->first()->name_da);
            $activeWorksheet->setCellValue('L'.$row_count, $project->management_departments->first()->name_da);
            $activeWorksheet->setCellValue('M'.$row_count, $project->design_departments->first()->name_da);
            $activeWorksheet->setCellValue('N'.$row_count, 'جدید');
            $activeWorksheet->setCellValue('P'.$row_count, $percentage_design.'%');

            $activeWorksheet->setCellValue('S'.$row_count, ($percentage_impliment != '0') ? $percentage_impliment.'%':'');


            if($project->impliment_departments->first()->name_da == "سکتور خصوصی" or $project->impliment_departments->first()->name_da == "سکتور_خصوصی"){
                $procurement = Depratment::where('name_da','LIKE','%ریاست%')->where('name_da','LIKE','%تدارکات%')->where('status','=','1')->first();
                if($project->procurement_type == '0'){
                    $percentage_internal_procurement = ReportProjectTracking::where('report_project_tracking.project_id', $project->id)
                    ->where('report_project_tracking.department_id', $procurement->id)
                    ->where('report_project_tracking.reject_activity', null)
                    ->join('department_activities', 'department_activities.id', '=', 'report_project_tracking.department_activity_id')
                    ->sum('department_activities.acitvity_percentage');

                    $activeWorksheet->setCellValue('Q'.$row_count, $percentage_internal_procurement.'%');

                }elseif($project->procurement_type == '1'){

                    $percentage_national_procurement = ReportProjectTracking::where('report_project_tracking.project_id', $project->id)
                    ->where('report_project_tracking.department_id', $procurement->id)
                    ->where('report_project_tracking.reject_activity', null)
                    ->join('department_activities', 'department_activities.id', '=', 'report_project_tracking.department_activity_id')
                    ->sum('department_activities.acitvity_percentage');
                    $activeWorksheet->setCellValue('R'.$row_count, $percentage_national_procurement.'%');
                }
                $date_after_design =  ProjectTracking::where('project_id','=',$project->id)->where('department_id','=',$procurement->id)->first();
                $activeWorksheet->setCellValue('U'.$row_count, jdate($date_after_design->date_of_send)->format('Y-m-d'));

            }else{
                // dd(jdate($date_after_design->date_of_send)->format('Y-m-d'));

                $date_after_design =  ProjectTracking::where('project_id','=',$project->id)->where('department_id','=',$project->impliment_departments->first()->id)->first();
                $activeWorksheet->setCellValue('U'.$row_count, jdate($date_after_design->date_of_send)->format('Y-m-d'));

                $activeWorksheet->setCellValue('Q'.$row_count, "مربوط به تدارکات نیست")->mergeCells('Q'.$row_count.':'.'R'.$row_count);
            }

            // if($project->impliment_departments->first()->name_da == 'سکتور خصوصی' or $project->impliment_departments->first()->name_da == 'سکتور_خصوصی'){

            // }



            // اضافه کردن باردار به سلول‌ها
            $activeWorksheet->getStyle('A'.$row_count.':AC'.$row_count)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);

            $row_count++;

        }
         // تنظیم عرض خودکار ستون‌ها
        // foreach (range('A', 'AC') as $columnID) {
        //     $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        // }
        function generateColumnRange($start, $end) {
            $columns = [];
            for ($i = $start; $i <= $end; $i++) {
                $columns[] = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);
            }
            return $columns;
        }

        foreach (generateColumnRange(1, 29) as $columnID) { // 1 to 29 corresponds to 'A' to 'AC'
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }


        // $writer = new Xlsx($spreadsheet);
        // $writer->save($file_name.'.xlsx');

        // تنظیم هدرهای HTTP برای دانلود فایل
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$file_name.'.xlsx');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        // exit;
    }
}
