#!/bin/bash
cd /xampp/htdocs/ncip-nuevaecija
php artisan tinker <<'EOF'
\App\Models\AdminNotification::count();
EOF
