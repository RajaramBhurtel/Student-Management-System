<?php 
require_once './config/db.php';
$query = "SELECT users.*, personal.* FROM users JOIN personal ON users.id = personal.user_id WHERE users.role ='1'";
$result = mysqli_query($conn, $query);
  

?>

<main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-0">Student Details</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Stusent Details</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-md-11">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Student</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Address</th>
                          <th>Phone</th>
                          <th>Gender</th>
                          <th>DOB</th>
                          <th>Applied</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                            if (mysqli_num_rows($result) > 0) :
                                $i = 1;
                                while($user = mysqli_fetch_assoc($result)):
                        ?>
                                    <tr class="align-middle">
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $user['name'] ?></td>
                                    <td>
                                        <?php echo $user['email'] ?>
                                    </td>
                                    <td>
                                        <?php echo $user['address'] ?>
                                    </td>
                                    <td>
                                        <?php echo $user['phone'] ?>
                                    </td>
                                    <td>
                                        <?php echo $user['gender'] ?>
                                    </td>
                                    <td>
                                        <?php echo $user['dob'] ?>
                                    </td>
                                    <td><?php echo $user['created_at'] ?></td>
                                    </tr>
                        <?php
                                endwhile;
                            else:
                        ?>
                                <tr>
                                    <td colspan="8" class="text-center">No students found.</td>
                                </tr>
                        <?php
                            endif;
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-end">
                      <li class="page-item">
                        <a class="page-link" href="#">&laquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="#">1</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="#">2</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="#">3</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="#">&raquo;</a>
                      </li>
                    </ul>
                  </div>
                </div>
               
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>