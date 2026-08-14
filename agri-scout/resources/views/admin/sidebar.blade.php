<div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
      <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar"><img src="{{ asset('adminD/img/avatar-6.jpg') }}" alt="..." class="img-fluid rounded-circle"></div>
          <div class="title">
            <h1 class="h5">Nadun Manthilaka</h1>
            <p>Web Designer</p>
          </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Menu</span>
        <ul class="list-unstyled">
                <li class="active"><a href="{{ url('dashboard') }}"> <i class="icon-home"></i>Home </a></li>

                <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Scout Farmers </a>
                  <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                    <li><a href="{{ url('add_farmer') }}">Add Farmer</a></li>

                    <li><a href="{{ url('view_farmers') }}">View Farmers</a></li>
                  </ul>
                </li>

                <li><a href="#exampledropdownDropdownFarms" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Scout Farms </a>
                  <ul id="exampledropdownDropdownFarms" class="collapse list-unstyled ">
                    <li><a href="{{ url('add_farm') }}">Add Farm</a></li>
                    <li><a href="{{ url('view_farms') }}">View Farms</a></li>
                  </ul>
                </li>
                 <li><a href="#exampledropdownDropdownOfficers" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Scout Officers </a>
                  <ul id="exampledropdownDropdownOfficers" class="collapse list-unstyled ">
                    <li><a href="{{ url('add_officer') }}">Add Officer</a></li>
                    <li><a href="{{ url('view_officers') }}">View Officers</a></li>
                  </ul>
                </li>

                <li class="active"><a href="{{ url('view_customers') }}"> <i class="icon-home"></i>Customers </a></li>
                <li class="active"><a href="{{ url('view_orders') }}"> <i class="icon-home"></i>Orders </a></li>
                 <li><a href="#exampledropdownDropdownCrops" aria-expanded="false" data-toggle="collapse"> <i class="icon-grid"></i>Crop Management </a>
                  <ul id="exampledropdownDropdownCrops" class="collapse list-unstyled ">
                    <li><a href="{{ route('admin.crops.index') }}">All Crops</a></li>
                    <li><a href="{{ route('admin.crops.create') }}">Add Crop</a></li>
                  </ul>
                </li>
                <li class="active"><a href="{{ url('view_visit_reports') }}"> <i class="icon-home"></i>Visit Reports </a></li>
                <li class="active"><a href="{{ url('view_disease_reports') }}"> <i class="icon-home"></i>Disease Reports </a></li>
                <li class="active"><a href="{{ url('view_activity_logs') }}"> <i class="icon-home"></i>Activity Logs </a></li>

        </ul>
      </nav>
