<?php

namespace App\Http\Controllers;

use App\Models\QuizHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $selectedDate = $request->get('date');
        $period = $request->get('period', 'month');

        // 履歴テーブル（日付絞り込み対応）
        $query = QuizHistory::where('user_id', $user->id)->with('word');
        if ($selectedDate) {
            $query->whereDate('answered_at', $selectedDate);
        }
        $histories = $query->latest('answered_at')->paginate(20);

        $totalQuizzes   = QuizHistory::where('user_id', $user->id)->count();
        $correctQuizzes = QuizHistory::where('user_id', $user->id)->where('is_correct', true)->count();
        $averageScore   = $totalQuizzes > 0 ? round($correctQuizzes / $totalQuizzes * 100) : 0;

        // 今月のカレンダーデータ
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth   = $now->copy()->endOfMonth();

        $monthlyData = QuizHistory::where('user_id', $user->id)
            ->whereBetween('answered_at', [$startOfMonth, $endOfMonth])
            ->selectRaw('DATE(answered_at) as date, COUNT(*) as count, SUM(is_correct) as correct')
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        // グラフデータ（期間別）
        $graphData = [];
        switch ($period) {
            case 'day':
                // 今日の時間別
                for ($h = 0; $h < 24; $h++) {
                    $data = QuizHistory::where('user_id', $user->id)
                        ->whereDate('answered_at', $now->format('Y-m-d'))
                        ->whereRaw('HOUR(answered_at) = ?', [$h])
                        ->selectRaw('COUNT(*) as count, SUM(is_correct) as correct')
                        ->first();
                    $graphData[] = [
                        'label'   => $h . '時',
                        'count'   => $data->count ?? 0,
                        'correct' => $data->correct ?? 0,
                    ];
                }
                break;
            case 'week':
                // 過去7日間
                for ($i = 6; $i >= 0; $i--) {
                    $date = $now->copy()->subDays($i);
                    $data = QuizHistory::where('user_id', $user->id)
                        ->whereDate('answered_at', $date->format('Y-m-d'))
                        ->selectRaw('COUNT(*) as count, SUM(is_correct) as correct')
                        ->first();
                    $graphData[] = [
                        'label'   => $date->format('m/d'),
                        'count'   => $data->count ?? 0,
                        'correct' => $data->correct ?? 0,
                    ];
                }
                break;
            case 'year':
                // 過去12ヶ月
                for ($i = 11; $i >= 0; $i--) {
                    $month = $now->copy()->subMonths($i);
                    $data = QuizHistory::where('user_id', $user->id)
                        ->whereYear('answered_at', $month->year)
                        ->whereMonth('answered_at', $month->month)
                        ->selectRaw('COUNT(*) as count, SUM(is_correct) as correct')
                        ->first();
                    $graphData[] = [
                        'label'   => $month->format('Y/m'),
                        'count'   => $data->count ?? 0,
                        'correct' => $data->correct ?? 0,
                    ];
                }
                break;
            default:
                // 今月（日別）
                for ($i = 1; $i <= $now->daysInMonth; $i++) {
                    $date = $now->copy()->startOfMonth()->addDays($i - 1);
                    $data = QuizHistory::where('user_id', $user->id)
                        ->whereDate('answered_at', $date->format('Y-m-d'))
                        ->selectRaw('COUNT(*) as count, SUM(is_correct) as correct')
                        ->first();
                    $graphData[] = [
                        'label'   => $i . '日',
                        'count'   => $data->count ?? 0,
                        'correct' => $data->correct ?? 0,
                    ];
                }
                break;
        }

        $daysInMonth = $startOfMonth->daysInMonth;
        $firstDayOfWeek = $startOfMonth->dayOfWeek;

        return view('history.index', compact(
            'histories',
            'totalQuizzes',
            'correctQuizzes',
            'averageScore',
            'monthlyData',
            'graphData',
            'now',
            'daysInMonth',
            'firstDayOfWeek',
            'selectedDate',
            'period'
        ));
    }
}