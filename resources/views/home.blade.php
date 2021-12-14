@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-4">
            <form action="{{ route('inflow.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add New Inflow</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" class="form-control" id="description" placeholder="Enter description">
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" class="form-control" id="amount" placeholder="Enter amount">
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" class="form-control" id="date" placeholder="Enter date">
                        </div>
                        <div class="form-group">
                            <select name="category_id" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="portion" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-4">
            <form action="{{ route('outflow.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Add New OutFlow</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" class="form-control" id="description" placeholder="Enter description">
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" class="form-control" id="amount" placeholder="Enter amount">
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" class="form-control" id="date" placeholder="Enter date">
                        </div>
                        <div class="form-group">
                            <select name="category_id" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="portion" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-4">
            <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Add New Category</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <canvas id="inflowsPiePerCategory" width="400" height="400"></canvas>
        </div>
        <div class="col-4">
            <canvas id="outflowsPiePerCategory" width="400" height="400"></canvas>
        </div>
        <div class="col-4">
            <canvas id="inflowsVsOutflowsPie" width="400" height="400"></canvas>
        </div>
        <div class="col-12">
            <canvas id="inflowsVsOutflowsPerDayLine" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col-5">
            <div class="row">
                @foreach ($inflowsPerMonth as $month => $inflows)
                    <div class="col-12">
                        <div class="card card-dark">
                            <div class="card-header">
                                <h3 class="card-title">{{ $month }}</h3>
                            </div>
                            <div class="card-body" style="height: 480px; overflow-y: auto;">
                                <table class="table table-bordered table-dark">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            {{-- <th>Description</th> --}}
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-green">
                                            <td colspan="2">Total</td>
                                            <td colspan="3"><b>{{ $inflows->sum('amount') }}</b></td>
                                        </tr>
                                        @foreach ($inflows as $inflow)
                                            <tr>
                                                <td>{{ $inflow->id }}</td>
                                                <td>{{ $inflow->name }}</td>
                                                {{-- <td>{{ $inflow->description }}</td> --}}
                                                <td>{{ $inflow->amount }}</td>
                                                <td>{{ $inflow->date }}</td>
                                                <td>{{ $inflow->category->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-7">
            <div class="row">
                @foreach ($outflowsPerMonth as $month => $outflows)
                    <div class="col-8">
                        <div class="card card-dark">
                            <div class="card-header">
                                <h3 class="card-title">{{ $month }}</h3>
                            </div>
                            <div class="card-body" style="height: 480px; overflow-y: auto;">
                                <table class="table table-bordered table-dark">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            {{-- <th>Description</th> --}}
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-red">
                                            <td colspan="2">Total</td>
                                            <td colspan="3"><b>{{ $outflows->sum('amount') }}</b></td>
                                        </tr>
                                        @foreach ($outflows as $outflow)
                                            <tr>
                                                <td>{{ $outflow->id }}</td>
                                                <td>{{ $outflow->name }}</td>
                                                {{-- <td>{{ $outflow->description }}</td> --}}
                                                <td>{{ $outflow->amount }}</td>
                                                <td>{{ $outflow->date }}</td>
                                                <td>{{ $outflow->category->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card card-dark">
                            <div class="card-header">
                                <h3 class="card-title">{{ $month }}</h3>
                            </div>
                            <div class="card-body" style="height: 480px; overflow-y: auto;">
                                Balance:<br>
                                @php($balance = $inflowsPerMonth->get($month)->sum('amount') - $outflows->sum('amount'))
                                <b class="{{ $balance < 0 ? 'text-danger' : 'text-success' }}">{{ $balance }}</b>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop

@section('css')
    <meta name="inflows-categories" content="{{ json_encode($inflowsPerCategory) }}" />
    <meta name="outflows-categories" content="{{ json_encode($outflowsPerCategory) }}" />
    <meta name="inflows-vs-outflows" content="{{ json_encode($inflowsVsOutflows) }}" />
    <meta name="inflows-per-day" content="{{ json_encode($inflowsPerDay) }}" />
    <meta name="outflows-per-day" content="{{ json_encode($outflowsPerDay) }}" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.2/dist/chart.min.js" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
@stop
