<!DOCTYPE html>
<html>
  <head>
    @include('admin.css')

<style>
    /* ================================
       FARM MANAGEMENT SYSTEM THEME
       ================================ */

    :root {
        --farm-green: #2e7d32;
        --farm-dark-green: #1b5e20;
        --farm-light-green: #66bb6a;
        --farm-leaf: #43a047;
        --farm-cream: #f7f5e8;
        --farm-earth: #8d6e63;
        --farm-white: #ffffff;
        --farm-text: #263238;
    }

    /* Page Background */
    body {
        background: linear-gradient(135deg, #f1f8e9, #fffde7);
        color: var(--farm-text);
        font-family: "Segoe UI", Arial, sans-serif;
    }

    /* Main Form Container */
    .farm-form {
        max-width: 650px;
        margin: 50px auto;
        padding: 35px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(46, 125, 50, 0.15);
        border: 1px solid rgba(76, 175, 80, 0.15);

        /* Animation */
        animation: formAppear 0.7s ease-out;
    }

    /* Form Heading */
    .farm-form h2 {
        text-align: center;
        color: var(--farm-dark-green);
        font-weight: 700;
        margin-bottom: 30px;
    }

    .farm-form h2::before {
        content: "🌱 ";
    }

    /* Form Groups */
    .farm-form .form-group {
        margin-bottom: 20px;
        animation: slideUp 0.6s ease both;
    }

    .farm-form .form-group:nth-child(2) {
        animation-delay: 0.1s;
    }

    .farm-form .form-group:nth-child(3) {
        animation-delay: 0.2s;
    }

    .farm-form .form-group:nth-child(4) {
        animation-delay: 0.3s;
    }

    /* Labels */
    .farm-form label {
        display: block;
        margin-bottom: 7px;
        font-weight: 600;
        color: var(--farm-dark-green);
    }

    /* Input Fields */
    .farm-form input {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #dce8d7;
        border-radius: 10px;
        outline: none;
        font-size: 15px;
        background: #fbfdf9;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    /* Input Focus Animation */
    .farm-form input:focus {
        border-color: var(--farm-green);
        background: white;
        box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.12);
        transform: translateY(-2px);
    }

    /* Submit Button */
    .farm-form .btn-primary {
        width: 100%;
        margin-top: 10px;
        padding: 13px 20px;
        border: none;
        border-radius: 12px;

        background: linear-gradient(
            135deg,
            var(--farm-green),
            var(--farm-dark-green)
        );

        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;

        box-shadow: 0 8px 18px rgba(46, 125, 50, 0.25);
        transition: all 0.3s ease;
    }

    /* Button Hover */
    .farm-form .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(46, 125, 50, 0.35);
        background: linear-gradient(
            135deg,
            var(--farm-light-green),
            var(--farm-green)
        );
    }

    /* Button Click */
    .farm-form .btn-primary:active {
        transform: scale(0.97);
    }

    /* ================================
       ANIMATIONS
       ================================ */

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

    /* Small Leaf Animation */
    .farm-form::after {
        content: "🌿";
        position: absolute;
        font-size: 35px;
        animation: leafFloat 3s ease-in-out infinite;
    }

    @keyframes leafFloat {
        0%, 100% {
            transform: translateY(0) rotate(-5deg);
        }

        50% {
            transform: translateY(-8px) rotate(5deg);
        }
    }

    /* Mobile */
    @media (max-width: 768px) {
        .farm-form {
            margin: 25px 15px;
            padding: 25px;
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


<div class="farm-form">

    <h2>Add New Farmer</h2>

    <form action="new_farmer" method="POST">

        @csrf

        <div class="form-group">
            <label for="name">Farmer Name</label>
            <input
                type="text"
                id="name"
                name="name"
                placeholder="Enter farmer name"
                required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input
                type="tel"
                id="phone"
                name="phone"
                placeholder="Enter phone number"
                required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter email address">
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input
                type="text"
                id="address"
                name="address"
                placeholder="Enter farmer address"
                required>
        </div>

        <div class="form-group">
            <input
                class="btn btn-primary"
                type="submit"
                value="🌱 Add Farmer">
        </div>

    </form>

</div>


            </div>
            </div>
          </div>
        @include('admin.footer')
  </body>
</html>
