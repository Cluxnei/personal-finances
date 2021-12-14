<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inflow;
use App\Models\Outflow;
use Carbon\Carbon;
use Facade\Ignition\ErrorPage\Renderer;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): Renderable
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $inflowsPerMonth = auth()->user()->inflows()->startsAt($startDate)->endsAt($endDate)->with('category')->orderBy('date')->get()
            ->groupBy(static fn (Inflow $inflow) => $inflow->date->format('m/Y'));

        $outflowsPerMonth = auth()->user()->outflows()->startsAt($startDate)->endsAt($endDate)->with('category')->orderBy('date')->get()
            ->groupBy(static fn (Outflow $outflow) => $outflow->date->format('m/Y'));

        $inflowsPerCategory = auth()->user()->inflows()->startsAt($startDate)->endsAt($endDate)->with('category')->orderBy('date')->get()
            ->groupBy(static fn (Inflow $inflow) => $inflow->category->name)->map(static fn ($inflows, $category) => [
                $category => $inflows->sum('amount'),
            ])->values()->reduce(static fn ($carry, $inflows) => $carry + $inflows, []);

        $outflowsPerCategory = auth()->user()->outflows()->startsAt($startDate)->endsAt($endDate)->with('category')->orderBy('date')->get()
            ->groupBy(static fn (Outflow $inflow) => $inflow->category->name)->map(static fn ($outflows, $category) => [
                $category => $outflows->sum('amount'),
            ])->values()->reduce(static fn ($carry, $outflows) => $carry + $outflows, []);

        $inflowsVsOutflows = ['inflows' => array_sum(array_values($inflowsPerCategory)), 'outflows' => array_sum(array_values($outflowsPerCategory))];

        $inflowsPerDay = auth()->user()->inflows()->startsAt($startDate)->endsAt($endDate)->with('category')->orderBy('date')->get()
            ->groupBy(static fn (Inflow $inflow) => $inflow->date->format('d/m/Y'))->map(static fn ($inflows, $date) => [
                $date => $inflows->sum('amount'),
            ])->values()->reduce(static fn ($carry, $inflows) => $carry + $inflows, []);

        $outflowsPerDay = auth()->user()->outflows()->startsAt($startDate)->endsAt($endDate)->with('category')->orderBy('date')->get()
            ->groupBy(static fn (Outflow $outflow) => $outflow->date->format('d/m/Y'))->map(static fn ($outflows, $date) => [
                $date => $outflows->sum('amount'),
            ])->values()->reduce(static fn ($carry, $outflows) => $carry + $outflows, []);

        $categories = Category::all();
        return view('home', compact(
            'categories',
            'inflowsPerMonth',
            'outflowsPerMonth',
            'inflowsPerCategory',
            'outflowsPerCategory',
            'inflowsVsOutflows',
            'inflowsPerDay',
            'outflowsPerDay'
        ));
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        Category::create($request->all());
        return redirect()->back();
    }
    public function storeInflow(Request $request): RedirectResponse
    {
        $portion = $request->portion ?? 1;
        $data = $request->all() + ['user_id' => auth()->id()];
        for ($i = 0; $i < $portion; $i++) {
            $data['date'] = Carbon::parse($request->date)->addMonths($i);
            Inflow::create($data);
        }
        return redirect()->back();
    }
    public function storeOutflow(Request $request): RedirectResponse
    {
        $portion = $request->portion ?? 1;
        $data = $request->all() + ['user_id' => auth()->id()];
        for ($i = 0; $i < $portion; $i++) {
            $data['date'] = Carbon::parse($request->date)->addMonths($i);
            Outflow::create($data);
        }
        return redirect()->back();
    }
}
