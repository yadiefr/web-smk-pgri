<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo e(setting('nama_sekolah', 'SMK PGRI CIKAMPEK')); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('css/login-light.css')); ?>?v=<?php echo e(time()); ?>" rel="stylesheet">
</head>
<body>
    <!-- Background -->
    <div class="space-bg">
        <!-- Decorative Elements -->
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
                SELAMAT DATANG DI<br>
                <span class="adventure-text"><?php echo e(strtoupper(setting('nama_sekolah', 'SMK PGRI CIKAMPEK'))); ?></span>
            </h1>
            <p class="welcome-description">
                Akses sistem pembelajaran digital <?php echo e(setting('nama_sekolah', 'SMK PGRI CIKAMPEK')); ?> dan mulai perjalanan edukasimu menuju masa depan yang gemilang.
            </p>
        </div>
        
        <!-- Login Section -->
        <div class="login-section">
            <div class="login-card">
                <h2 class="login-title">Masuk</h2>
                <p class="login-subtitle">Silakan masuk ke akun Anda</p>
                
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
        });
    </script>
</body>
</html>
<?php /**PATH C:\wamp64\www\website-smk3\resources\views/auth/login.blade.php ENDPATH**/ ?>