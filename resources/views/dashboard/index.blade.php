@extends('layouts.app')

@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-graduation-cap"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Category</span>
              <span class="info-box-number">
                10
                <small>%</small>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-archive"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Product</span>
              <span class="info-box-number">10</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        

      </div>
      <!-- /.row -->

      <!--- App Users --->
      <div class="row">
        <div class="col-md-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">App Users</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!--table -->
                <table id="DataTable" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>UserName</th>
                    <th>Email</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                      <tr>
                        <td>Abc</td>
                        <td>--</td>
                        <td>
                          <button class="btn btn-xs btn-danger">Delete</button>
                        </td>
                      </tr>
                  </tbody>
                </table>
                <!--table -->
  
            </div>
            <!-- /.card-body -->
        
          </div>
          <!-- /.card -->
        </div>
    </div>
      <!--- /.App Users --->

     
</div><!--/. container-fluid -->
  </section>
  <!-- /.content -->

@endsection