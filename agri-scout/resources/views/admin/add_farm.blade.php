<!DOCTYPE html>
<html>
  <head>
    @include('admin.css')

<style>
    /* ================================
       FARM MANAGEMENT FORM
       ================================ */

    .farm-form-wrapper {
        max-width: 720px;
        margin: 40px auto;
        padding: 35px;

        background: #ffffff;
        border-radius: 20px;

        border: 1px solid #dce8dc;

        box-shadow:
            0 10px 30px rgba(34, 90, 45, 0.12);

        animation: formAppear 0.7s ease-out;
    }

    /* Header */
    .farm-form-title {
        text-align: center;
        margin-bottom: 30px;
    }

    .farm-icon {
        width: 65px;
        height: 65px;

        margin: 0 auto 12px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #e8f5e9;
        border-radius: 50%;

        font-size: 32px;

        animation: floatIcon 3s ease-in-out infinite;
    }

    .farm-form-title h2 {
        margin: 0;

        color: #1b5e20;

        font-size: 28px;
        font-weight: 700;
    }

    .farm-form-title p {
        margin-top: 7px;

        color: #78909c;
        font-size: 14px;
    }

    /* Form Group */
    .form-group {
        margin-bottom: 20px;

        animation: slideUp 0.6s ease both;
    }

    /* Label */
    .form-group label {
        display: block;

        margin-bottom: 8px;

        color: #2e5d34;

        font-size: 14px;
        font-weight: 600;
    }

    /* Input and Select */
    .form-group input,
    .form-group select {

        width: 100%;
        height: 48px;

        padding: 0 15px;

        box-sizing: border-box;

        border: 1.5px solid #cfdccf;

        border-radius: 10px;

        background: #fafffa;

        color: #263238;

        font-size: 15px;

        outline: none;

        transition:
            border-color 0.3s ease,
            box-shadow 0.3s ease,
            transform 0.3s ease,
            background 0.3s ease;
    }

    /* Select */
    .form-group select {
        cursor: pointer;
    }

    /* Focus Effect */
    .form-group input:focus,
    .form-group select:focus {

        border-color: #43a047;

        background: #ffffff;

        box-shadow:
            0 0 0 4px rgba(67, 160, 71, 0.12);

        transform: translateY(-2px);
    }

    /* Placeholder */
    .form-group input::placeholder {
        color: #9aa99c;
    }

    /* Submit Button */
    .form-group .btn-primary {

        width: 100%;
        height: 50px;

        border: none;
        border-radius: 10px;

        background: linear-gradient(
            135deg,
            #43a047,
            #1b5e20
        );

        color: white;

        font-size: 16px;
        font-weight: 600;

        cursor: pointer;

        box-shadow:
            0 7px 18px rgba(46, 125, 50, 0.25);

        transition: all 0.3s ease;
    }

    /* Button Hover */
    .form-group .btn-primary:hover {

        transform: translateY(-3px);

        box-shadow:
            0 12px 25px rgba(46, 125, 50, 0.35);

        background: linear-gradient(
            135deg,
            #66bb6a,
            #2e7d32
        );
    }

    /* Button Click */
    .form-group .btn-primary:active {
        transform: scale(0.97);
    }

    /* Form Animation */
    @keyframes formAppear {

        from {
            opacity: 0;
            transform: translateY(30px) scale(0.97);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Input Animation */
    @keyframes slideUp {

        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Floating Icon */
    @keyframes floatIcon {

        0%,
        100% {
            transform: translateY(0) rotate(-3deg);
        }

        50% {
            transform: translateY(-7px) rotate(3deg);
        }
    }

    /* Different animation delays */
    .form-group:nth-child(1) {
        animation-delay: 0.1s;
    }

    .form-group:nth-child(2) {
        animation-delay: 0.2s;
    }

    .form-group:nth-child(3) {
        animation-delay: 0.3s;
    }

    .form-group:nth-child(4) {
        animation-delay: 0.4s;
    }

    .form-group:nth-child(5) {
        animation-delay: 0.5s;
    }

    .form-group:nth-child(6) {
        animation-delay: 0.6s;
    }

    /* Mobile */
    @media (max-width: 600px) {

        .farm-form-wrapper {
            width: 90%;
            padding: 25px 20px;
            margin: 25px auto;
        }

        .farm-form-title h2 {
            font-size: 23px;
        }

    }
</style>


  </head>
  <body>
    @include('admin.header')
    @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">



<form action="{{ url('/new_farm') }}" method="POST">
            <h2>Add New Farm</h2>
    @csrf

    <div class="form-group">
        <label for="farmer_id">Farmer</label>

        <select
            id="farmer_id"
            name="farmer_id"
            required>

            <option value="">-- Select Farmer --</option>

            @foreach($farmers ?? collect() as $farmer)
                <option value="{{ $farmer->FARMER_ID }}">
                    {{ $farmer->NAME ?? 'Farmer' }} - {{ $farmer->EMAIL ?? $farmer->FARMER_ID }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="form-group">
        <label for="farmname">Farm Name</label>

        <input
            type="text"
            id="farmname"
            name="farmname"
            placeholder="Enter farm name"
            required>
    </div>

    <div class="form-group">
        <label for="location">Location</label>

        <input
            type="text"
            id="location"
            name="location"
            placeholder="Enter farm location"
            required>
    </div>

    <div class="form-group">
        <label for="district">District</label>

        <input
            type="text"
            id="district"
            name="district"
            placeholder="Enter district"
            required>
    </div>

    <div class="form-group">
        <label for="area">Area</label>

        <input
            type="number"
            step="0.01"
            id="area"
            name="area"
            placeholder="Enter farm area"
            required>
    </div>

    <div class="form-group">
        <input
            class="btn btn-primary"
            type="submit"
            value="🌱 Add Farm">
    </div>

</form>


            </div>
            </div>
          </div>


        @include('admin.footer')
  </body>
</html>
