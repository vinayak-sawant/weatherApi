<!DOCTYPE html>
<html>
<head>
    <title>Weather App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" />

    <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" />
    <script type="text/javascript">
        $(document).ready(function() {
            $('#weatherTable').DataTable();
        } );
    </script>

</head>
<body>
   
<div class="container">
    <h1 align="center">Weather App</h1>
   
    <div class="card">
      <div class="card-header">
        <form method="POST" action="{{ route('submitWeather') }}">
            @csrf
            <div class="input-group mb-3">
              <input type="text" name="city" required="true" class="form-control" placeholder="Enter City">
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Get Weather Data</button>
              </div>
            </div>
        </form>
      </div>
      <div class="card-body">
   
            @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif

            @if (Session::has('warning'))
                <div class="alert alert-warning" role="alert">
                    {{ Session::get('warning') }}
                </div>
            @endif

             @if (Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
   
            <table id="weatherTable" class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>City</th>
                        <th>Weather ID</th>
                        <th>Main</th>
                        <th>Description</th>
                        <th>Icon</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($weatherData as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->date }}</td>
                            <td>{{ $row->city }}</td>
                            <td>{{ $row->weather_id }}</td>
                            <td>{{ $row->main }}</td>
                            <td>{{ $row->description }}</td>
                            <td>{{ $row->icon }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
      </div>
    </div>
   
</div>
    
</body>
</html>