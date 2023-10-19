APP_NAME="First Bank Middleware"
APP_ENV=local
APP_KEY=base64:KuzvJPFn1JCvr0B25F5OtQbCGw9TfIxZLgHeBgYhXYg=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perx_db_user
DB_USERNAME=perx_user
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

COMPANY_ID = 3

# FROM_EMAIL=noreply@fidelitybank.ng
# EMAIL_SERVICE_URL=https://bpr-002.fidelitybank.ng/bankapi/messaging/v1/email/send
# EMAIL_SERVICE_URL_BANK_DEMO=https://openapigateway.fidelitybank.ng/BankAPI/messaging/v1/email/send
# EMAIL_SERVICE_URL_LSL_LIVE=https://loyaltysolutionsnigeria.com/email_templates/sendmail2.php

# FROM_EMAIL=noreply@firstbank.ng
# EMAIL_SERVICE_URL=https://bpr-002.fidelitybank.ng/bankapi/messaging/v1/email/send
# EMAIL_SERVICE_URL_BANK_DEMO=https://openapigateway.fidelitybank.ng/BankAPI/messaging/v1/email/send
EMAIL_SERVICE_URL_LSL_LIVE=https://loyaltysolutionsnigeria.com/email_templates/sendmail2.php


# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=perx_database
# DB_USERNAME=perx_database_user
# DB_PASSWORD=perxDemo44!
