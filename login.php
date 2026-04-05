<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RIO-SYSTEM | Secure Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #000000; /* Hitam Total */
        }
        
        /* Grid Pattern samar agar tidak terlalu polos */
        .bg-cyber {
            background-image: 
                linear-gradient(rgba(56, 189, 248, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(56, 189, 248, 0.03) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .rio-glass {
            background: rgba(10, 15, 25, 0.8);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(56, 189, 248, 0.15);
            box-shadow: 0 0 50px rgba(0, 0, 0, 1);
        }

        .scan-line {
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(56, 189, 248, 0.5), transparent);
            position: absolute;
            top: 0;
            left: 0;
            animation: scan 3s linear infinite;
        }

        @keyframes scan {
            0% { top: 0; opacity: 0; }
            50% { opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }

        /* Input styling untuk membuang warna putih */
        input {
            background: rgba(0, 0, 0, 0.5) !important;
            color: white !important;
        }
        
        input::placeholder {
            color: #334155 !important;
        }
    </style>
</head>
<body class="bg-cyber min-h-screen flex items-center justify-center p-6 overflow-hidden relative">

    <div class="absolute top-[-20%] left-[-10%] w-[600px] h-[600px] bg-sky-900/20 rounded-full blur-[150px]"></div>
    <div class="absolute bottom-[-20%] right-[-10%] w-[600px] h-[600px] bg-indigo-950/30 rounded-full blur-[150px]"></div>

    <div class="w-full max-w-md relative z-10">
        <div class="text-center mb-10">
            <div class="inline-flex p-5 bg-slate-950 border border-sky-500/30 rounded-3xl shadow-[0_0_30px_rgba(14,165,233,0.2)] mb-5 transform -rotate-3 hover:rotate-0 transition-transform">
                <i class="fas fa-fingerprint text-4xl text-sky-500"></i>
            </div>
            <h1 class="text-white text-3xl font-black tracking-[-1px] uppercase">RIO-<span class="text-sky-500">SYSTEM</span></h1>
            <div class="flex items-center justify-center gap-2 mt-1">
                <span class="h-[1px] w-5 bg-sky-900"></span>
                <p class="text-slate-600 text-[10px] uppercase tracking-[4px] font-bold">Secure Monitoring System</p>
                <span class="h-[1px] w-5 bg-sky-900"></span>
            </div>
        </div>

        <div class="rio-glass p-8 md:p-12 rounded-[3rem] shadow-2xl relative overflow-hidden">
            <div class="scan-line"></div>
            
            <div class="mb-8">
                <h2 class="text-white text-xl font-bold italic tracking-tight">TERMINAL LOGIN</h2>
                <p class="text-slate-600 text-xs mt-1 uppercase tracking-wider font-semibold">Node Access Required</p>
            </div>

            <form action="./process/login_process.php" method="POST" class="space-y-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-sky-500/50 uppercase tracking-[2px] ml-1">Identity Node</label>
                    <div class="relative group">
                        <i class="fas fa-user-shield absolute left-4 top-1/2 -translate-y-1/2 text-slate-700 group-focus-within:text-sky-500 transition-colors"></i>
                        <input type="text" name="username" placeholder="NIS / USERNAME" 
                               class="w-full border border-white/5 rounded-2xl py-4 pl-12 pr-4 outline-none focus:border-sky-500/50 focus:ring-4 focus:ring-sky-500/5 transition-all font-medium" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-sky-500/50 uppercase tracking-[2px] ml-1">Access Key</label>
                    <div class="relative group">
                        <i class="fas fa-key absolute left-4 top-1/2 -translate-y-1/2 text-slate-700 group-focus-within:text-sky-500 transition-colors"></i>
                        <input type="password" name="password" placeholder="••••••••" 
                               class="w-full border border-white/5 rounded-2xl py-4 pl-12 pr-4 outline-none focus:border-sky-500/50 focus:ring-4 focus:ring-sky-500/5 transition-all font-medium" required>
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-sky-600 hover:bg-sky-500 text-white font-black py-4 rounded-2xl shadow-xl shadow-sky-900/40 transition-all transform hover:scale-[1.02] active:scale-[0.98] mt-4 flex items-center justify-center gap-3 tracking-[2px] text-xs">
                    INITIALIZE ACCESS <i class="fas fa-chevron-right text-[10px]"></i>
                </button>
            </form>

            <div class="mt-10 text-center border-t border-white/5 pt-6">
                <p class="text-slate-700 text-[10px] font-bold uppercase tracking-widest leading-relaxed">
                    Access Denied? <br>
                    <span class="text-sky-900">Contact System Administrator</span>
                </p>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-slate-800 text-[9px] uppercase tracking-[5px] font-black">
                SMK TI Bali Global Denpasar
            </p>
            <p class="text-slate-900 text-[8px] mt-2 font-bold uppercase tracking-[2px]">
                Dev: I Wayan Rio Nata Meranggi &copy; 2026
            </p>
        </div>
    </div>

</body>
</html>