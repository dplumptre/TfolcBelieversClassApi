<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  </head>
  <body>



  <div style="text-align:center">
    <img with="200px" height="200px"  src="{{url('/images/logo.png')}}" alt="logo">
   </div>

   <div class="text-danger my-3">
   <h5>MEMEBERS WHO HAVE COMPLETED BELIEVER'S CLASS</h5>
   </div>



    <table class="table table-bordered my-3 " style="font-size:14px">
    <thead>
      <tr>
        <th>S/n</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Status</th>
        <th>Gender</th>
        <th>Started</th>
        <th>Ended</th>
      </tr>
      </thead>
      <tbody>
      @foreach ($reports as $key => $data)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{ $data->fname }} {{ $data->lname }}</td>
            <td>{{ $data->email }}</td>
            <td>{{ $data->phone }}</td>
            <td>{{ $data->mstatus }}</td>
            <td>{{ $data->gender }}</td>
            <td>{{ $data->created_at }}</td>
            <td>{{ $data->completed_date }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>