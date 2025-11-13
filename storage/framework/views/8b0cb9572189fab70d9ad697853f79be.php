<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo e(setting('nama_sekolah', 'SMK PGRI CIKAMPEK')); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        :root {
            --space-dark: #1a0b2e;
            --space-purple: #7209b7;
            --space-blue: #2d1b69;
            --space-light: #a663cc;
            --planet-blue: #00c9ff;
            --planet-purple: #92fe9d;
            --text-white: #ffffff;
            --text-light: #b8c2cc;
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(ellipse at bottom, #1a0b2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            color: var(--text-white);
        }
        
        /* Space Background Elements */
        .space-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
        
        .planet {
            position: absolute;
            border-radius: 50%;
            opacity: 0.8;
            animation: float 8s ease-in-out infinite;
        }
        
        .planet-1 {
            width: 300px;
            height: 300px;
            top: -50px;
            left: -100px;
            background: linear-gradient(135deg, #00c9ff, #92fe9d);
            animation-delay: 0s;
        }
        
        .planet-2 {
            width: 200px;
            height: 200px;
            bottom: -50px;
            right: -50px;
            background: linear-gradient(135deg, #a18cd1, #fbc2eb);
            animation-delay: 2s;
        }
        
        .planet-3 {
            width: 150px;
            height: 150px;
            bottom: 100px;
            left: -25px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            animation-delay: 4s;
        }
        
        .stars {
            position: absolute;
            width: 100%;
            height: 100%;
        }
        
        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: white;
            border-radius: 50%;
            animation: twinkle 2s infinite;
        }
        
        .star:nth-child(1) { top: 20%; left: 20%; animation-delay: 0s; }
        .star:nth-child(2) { top: 40%; left: 70%; animation-delay: 0.5s; }
        .star:nth-child(3) { top: 70%; left: 30%; animation-delay: 1s; }
        .star:nth-child(4) { top: 80%; left: 80%; animation-delay: 1.5s; }
        .star:nth-child(5) { top: 30%; left: 50%; animation-delay: 2s; }
        .star:nth-child(6) { top: 60%; left: 10%; animation-delay: 2.5s; }
        .star:nth-child(7) { top: 10%; left: 90%; animation-delay: 3s; }
        .star:nth-child(8) { top: 90%; left: 40%; animation-delay: 3.5s; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(10deg); }
        }
        
        @keyframes twinkle {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.5); }
        }
        
        /* Main Container */
        .login-container {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            position: relative;
            z-index: 10;
            align-items: center;
        }
        
        /* Welcome Section */
        .welcome-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 80px 60px;
            position: relative;
        }
        
        .welcome-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.1;
            letter-spacing: -0.02em;
        }
        
        .adventure-text {
            color: var(--space-light);
            display: block;
        }
        
        .welcome-description {
            font-size: 1.1rem;
            color: var(--text-light);
            line-height: 1.7;
            margin-bottom: 40px;
            max-width: 500px;
        }
        
        .rocket {
            font-size: 2.5rem;
            margin-left: 15px;
            animation: rocket-fly 3s ease-in-out infinite;
        }
        
        @keyframes rocket-fly {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(8deg); }
        }
        
        /* Login Section */
        .login-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px 60px;
            position: relative;
        }
        
        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 35px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
            position: relative;
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            border-radius: 24px;
            pointer-events: none;
        }
        
        .login-title {
            font-size: 2.2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
            position: relative;
            z-index: 2;
        }
        
        .login-subtitle {
            font-size: 1rem;
            color: var(--text-light);
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 2;
        }
        
        /* Form Styling */
        .form-group {
            margin-bottom: 24px;
            position: relative;
            z-index: 2;
        }
        
        .form-control {
            width: 100%;
            padding: 18px 50px 18px 20px;
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid var(--glass-border);
            border-radius: 16px;
            color: var(--text-white);
            font-size: 1rem;
            font-family: inherit;
            font-weight: 400;
            transition: all 0.3s ease;
            outline: none;
        }
        
        .form-control:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: var(--space-light);
            box-shadow: 0 0 0 3px rgba(166, 99, 204, 0.15);
            transform: translateY(-2px);
        }
        
        .form-control::placeholder {
            color: var(--text-light);
            font-weight: 400;
        }
        
        .form-icon {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 3;
            font-size: 1.1rem;
        }
        
        .form-icon:hover {
            color: var(--space-light);
            transform: translateY(-50%) scale(1.1);
        }
            padding: 15px 50px 15px 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--text-white);
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
            outline: none;
        }
        
        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--space-light);
            box-shadow: 0 0 0 3px rgba(166, 99, 204, 0.2);
        }
        
        .form-control::placeholder {
            color: var(--text-light);
        }
        
        .form-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            cursor: pointer;
            transition: color 0.3s ease;
        }
        
        .form-icon:hover {
            color: var(--space-light);
        }
        
        /* Button Styling */
        .btn-login {
            width: 100%;
            padding: 18px 24px;
            background: linear-gradient(135deg, var(--space-purple), var(--space-blue));
            border: none;
            border-radius: 16px;
            color: var(--text-white);
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            z-index: 2;
            margin-top: 8px;
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(114, 9, 183, 0.5);
            background: linear-gradient(135deg, #8a2be2, #4169e1);
        }
        
        .btn-login:active {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(114, 9, 183, 0.3);
        }
        
        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }
        
        /* Social Login */
        .social-divider {
            text-align: center;
            margin: 32px 0 24px;
            position: relative;
            color: var(--text-light);
            font-size: 0.9rem;
            z-index: 2;
        }
        
        .social-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--glass-border);
            z-index: -1;
        }
        
        .social-divider span {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            padding: 0 20px;
        }
        
        .social-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            z-index: 2;
            position: relative;
        }
        
        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 14px 16px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--text-white);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        
        .social-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            color: var(--text-white);
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        
        .social-btn i {
            margin-right: 8px;
            font-size: 1.1rem;
        }
        
        .social-btn.google:hover {
            background: rgba(234, 67, 53, 0.2);
            border-color: rgba(234, 67, 53, 0.4);
        }
        
        .social-btn.facebook:hover {
            background: rgba(24, 119, 242, 0.2);
            border-color: rgba(24, 119, 242, 0.4);
        }
        
        .terms-text {
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-light);
            margin-top: 24px;
            line-height: 1.5;
            position: relative;
            z-index: 2;
        }
        
        .terms-text a {
            color: var(--space-light);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .terms-text a:hover {
            color: var(--text-white);
            text-decoration: underline;
        }
        
        /* Alert Styling */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            border: none;
            font-size: 0.9rem;
            position: relative;
            z-index: 2;
            backdrop-filter: blur(10px);
        }
        
        .alert-danger {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-left: 4px solid #ef4444;
        }
        
        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            color: #86efac;
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-left: 4px solid #22c55e;
        }-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo e(setting('nama_sekolah', 'SMK PGRI CIKAMPEK')); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        :root {
            --space-dark: #1a0b2e;
            --space-purple: #7209b7;
            --space-blue: #2d1b69;
            --space-light: #a663cc;
            --planet-blue: #00c9ff;
            --planet-purple: #92fe9d;
            --text-white: #ffffff;
            --text-light: #b8c2cc;
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(ellipse at bottom, #1a0b2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            color: var(--text-white);
        }
        
        /* Space Background Elements */
        .space-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
        
        .planet {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--planet-blue), var(--planet-purple));
            opacity: 0.8;
            animation: float 6s ease-in-out infinite;
        }
        
        .planet-1 {
            width: 200px;
            height: 200px;
            top: 10%;
            left: -5%;
            background: linear-gradient(135deg, #00c9ff, #92fe9d);
            animation-delay: 0s;
        }
        
        .planet-2 {
            width: 150px;
            height: 150px;
            top: 60%;
            right: -3%;
            background: linear-gradient(135deg, #a18cd1, #fbc2eb);
            animation-delay: 2s;
        }
        
        .planet-3 {
            width: 100px;
            height: 100px;
            bottom: 20%;
            left: 10%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            animation-delay: 4s;
        }
        
        /* Stars */
        .stars {
            position: absolute;
            width: 100%;
            height: 100%;
        }
        
        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: white;
            border-radius: 50%;
            animation: twinkle 2s infinite;
        }
        
        .star:nth-child(1) { top: 20%; left: 20%; animation-delay: 0s; }
        .star:nth-child(2) { top: 40%; left: 70%; animation-delay: 0.5s; }
        .star:nth-child(3) { top: 70%; left: 30%; animation-delay: 1s; }
        .star:nth-child(4) { top: 80%; left: 80%; animation-delay: 1.5s; }
        .star:nth-child(5) { top: 30%; left: 50%; animation-delay: 2s; }
        .star:nth-child(6) { top: 60%; left: 10%; animation-delay: 2.5s; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        @keyframes twinkle {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.2); }
        }
            border-radius: 5px;
            transition: background 0.3s;
        }
        .btn-auth:hover {
            background: #00c6ff;
        }
        .input-group-text {
            background: #4facfe;
            color: #fff;
            border: none;
        }
        .form-control {
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-check-label {
            font-size: 0.9rem;
        }
        
        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .welcome-section,
            .login-section {
                padding: 60px 40px;
            }
            
            .welcome-title {
                font-size: 3rem;
            }
        }
        
        @media (max-width: 768px) {
            .login-container {
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                align-items: stretch;
                min-height: 100vh;
            }
            
            .welcome-section {
                padding: 60px 30px 20px;
                text-align: center;
                align-items: center;
                flex-shrink: 0;
                max-height: 55vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
            
            .welcome-title {
                font-size: 2.2rem;
                margin-bottom: 15px;
            }
            
            .welcome-description {
                text-align: center;
                max-width: none;
                font-size: 1rem;
                margin-bottom: 20px;
            }
            
            .login-section {
                padding: 5px 30px 40px;
                justify-content: flex-start;
                flex: 1;
                display: flex;
                flex-direction: column;
            }
            
            .login-card {
                padding: 25px 30px;
                margin-top: 10px;
            }
            
            .planet-1 {
                width: 200px;
                height: 200px;
                top: -25px;
                left: -50px;
            }
            
            .planet-2 {
                width: 150px;
                height: 150px;
                bottom: -25px;
                right: -25px;
            }
            
            .planet-3 {
                width: 100px;
                height: 100px;
            }
        }
        
        @media (max-width: 480px) {
            .welcome-section {
                padding: 50px 20px 15px;
                flex-shrink: 0;
                max-height: 50vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
            
            .login-section {
                padding: 0px 20px 30px;
                justify-content: flex-start;
                flex: 1;
                display: flex;
                flex-direction: column;
            }
            
            .welcome-title {
                font-size: 1.8rem;
                margin-bottom: 10px;
                line-height: 1.1;
            }
            
            .welcome-description {
                font-size: 0.9rem;
                margin-bottom: 15px;
                line-height: 1.4;
            }
            
            .login-card {
                padding: 20px 20px;
                margin-top: 5px;
            }
            
            .login-title {
                font-size: 1.8rem;
            }
            
            .social-buttons {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            
            .form-control {
                padding: 16px 45px 16px 18px;
            }
            
            .btn-login {
                padding: 16px 20px;
            }
            
            .planet-1 {
                width: 150px;
                height: 150px;
            }
            
            .planet-2 {
                width: 100px;
                height: 100px;
            }
            
            .planet-3 {
                width: 80px;
                height: 80px;
            }
        }
        
        /* Extra small screens and short height */
        @media (max-width: 480px) and (max-height: 800px) {
            .welcome-section {
                padding: 20px 20px 5px;
            }
            
            .welcome-title {
                font-size: 1.6rem;
                margin-bottom: 8px;
            }
            
            .welcome-description {
                font-size: 0.9rem;
                margin-bottom: 15px;
            }
            
            .login-section {
                padding: 5px 20px 20px;
            }
            
            .login-card {
                padding: 20px 18px;
            }
            
            .login-title {
                font-size: 1.6rem;
                margin-bottom: 6px;
            }
            
            .login-subtitle {
                margin-bottom: 20px;
                font-size: 0.9rem;
            }
        }
        
        @media (max-height: 700px) {
            .welcome-section {
                padding: 15px 30px 5px;
            }
            
            .login-section {
                padding: 5px 30px 15px;
            }
            
            .welcome-title {
                margin-bottom: 10px;
            }
            
            .welcome-description {
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Space Background -->
    <div class="space-bg">
        <!-- Planets -->
        <div class="planet planet-1"></div>
        <div class="planet planet-2"></div>
        <div class="planet planet-3"></div>
        
        <!-- Stars -->
        <div class="stars">
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
        </div>
    </div>
    
    <!-- Main Container -->
    <div class="login-container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1 class="welcome-title">
                MASUK UNTUK MULAI<br>
                <span class="adventure-text">PETUALANGANMU!</span>
            </h1>
            <p class="welcome-description">
                Akses sistem pembelajaran digital <?php echo e(setting('nama_sekolah', 'SMK PGRI CIKAMPEK')); ?> dan mulai perjalanan edukasimu menuju masa depan yang gemilang.
            </p>
        </div>
        
        <!-- Login Section -->
        <div class="login-section">
            <div class="login-card">
                <!-- Error Messages -->
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($error); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
                
                <?php if(session('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>
                
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                
                <!-- Login Form -->
                <form method="POST" action="<?php echo e(route('login')); ?>" id="loginForm">
                    <?php echo csrf_field(); ?>
                    
                    <div class="form-group">
                        <input 
                            type="text" 
                            name="username" 
                            id="username"
                            class="form-control" 
                            placeholder="Email/NIS" 
                            value="<?php echo e(old('username')); ?>" 
                            required 
                            autocomplete="username"
                        >
                        <i class="form-icon fas fa-envelope"></i>
                    </div>
                    
                    <div class="form-group">
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            class="form-control" 
                            placeholder="Password" 
                            required 
                            autocomplete="current-password"
                        >
                        <i class="form-icon fas fa-eye toggle-password" onclick="togglePassword()"></i>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        <span>Masuk</span>
                    </button>
                </form>                
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        // Form Submission Enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const submitBtn = form.querySelector('.btn-login');
            
            form.addEventListener('submit', function() {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
                submitBtn.disabled = true;
            });
            
            // Auto dismiss alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.remove();
                        }
                    }, 300);
                }, 5000);
            });
            
            // Add focus effects
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\wamp64\www\website-smk3\resources\views/auth/login.blade.php ENDPATH**/ ?>