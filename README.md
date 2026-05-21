# WasenderAPI Laravel Package

Laravel package for [WasenderAPI](https://wasenderapi.com/api-docs), built to help you manage WhatsApp sessions, send messages, handle media, work with contacts, groups, channels, and receive webhooks from Laravel.


---

## العربية

### نبذة

هذه الحزمة توفر واجهة Laravel سهلة للتعامل مع WasenderAPI بدل كتابة طلبات HTTP يدويًا في كل مشروع. بعد تثبيتها يمكنك استخدام `Facade` جاهز مثل:

```php
use Ashraf\WasenderApi\Facades\WasenderApi;

WasenderApi::messages()->text('+1234567890', 'مرحبا من Laravel');
```

### المتطلبات

- PHP 8.1 أو أحدث
- Laravel 10 أو 11 أو 12 أو 13
- Composer
- حساب WasenderAPI
- `Personal Access Token` لإدارة الجلسات
- `Session API Key` لإرسال الرسائل والتعامل مع الجلسة

### التثبيت من GitHub

الحزمة غير منشورة على Packagist، عرّف المستودع داخل مشروع Laravel:

```bash
composer config repositories.wasenderapi-laravel vcs https://github.com/AshrafCodes/wasenderapi-laravel.git
composer require ashraf/wasenderapi-laravel:^1.1.0
او
composer require ashraf/wasenderapi-laravel:dev-main
```

er require ashraf/wasenderapi-laravel:dev-main
```



بعد التثبيت، انشر ملف الإعدادات:

```bash
php artisan vendor:publish --tag=wasenderapi-config
```

### إعداد ملف `.env`

أضف القيم التالية داخل مشروع Laravel:

```dotenv
WASENDERAPI_BASE_URL=https://www.wasenderapi.com/api
WASENDERAPI_PERSONAL_ACCESS_TOKEN=your_personal_access_token
WASENDERAPI_API_KEY=your_session_api_key
WASENDERAPI_WEBHOOK_SECRET=your_webhook_secret
```

### الفرق بين المفاتيح

- `WASENDERAPI_PERSONAL_ACCESS_TOKEN`: يستخدم لإدارة الجلسات مثل إنشاء جلسة، عرض الجلسات، إعادة تشغيل جلسة، حذف جلسة، وتجديد API key.
- `WASENDERAPI_API_KEY`: يستخدم لعمليات الجلسة نفسها مثل إرسال الرسائل، حالة الجلسة، جهات الاتصال، المجموعات، والقنوات.

الحزمة تختار المفتاح المناسب تلقائيًا في أغلب الطرق.

### إرسال رسالة نصية

```php
use Ashraf\WasenderApi\Facades\WasenderApi;

WasenderApi::messages()->text('+1234567890', 'مرحبا من Laravel');
```

### إرسال صورة

```php
WasenderApi::messages()->image(
    to: '+1234567890',
    imageUrl: 'https://example.com/image.jpg',
    text: 'صورة مع تعليق'
);
```

### إرسال فيديو

```php
WasenderApi::messages()->video(
    to: '+1234567890',
    videoUrl: 'https://example.com/video.mp4',
    text: 'فيديو جديد'
);
```

### إرسال ملف

```php
WasenderApi::messages()->document(
    to: '+1234567890',
    documentUrl: 'https://example.com/report.pdf',
    text: 'التقرير',
    fileName: 'report.pdf'
);
```

### إرسال موقع

```php
WasenderApi::messages()->location(
    to: '+1234567890',
    latitude: 37.7749,
    longitude: -122.4194,
    name: 'Company HQ',
    address: 'San Francisco'
);
```

### إرسال Poll

```php
WasenderApi::messages()->poll(
    to: '+1234567890',
    question: 'ما اللون المفضل؟',
    options: ['Blue', 'Green', 'Red'],
    multiSelect: false
);
```

### أنواع الرسائل المدعومة

- `text($to, $text, $extra = [])`
- `image($to, $imageUrl, $text = null, $extra = [])`
- `video($to, $videoUrl, $text = null, $extra = [])`
- `document($to, $documentUrl, $text = null, $fileName = null, $extra = [])`
- `audio($to, $audioUrl, $extra = [])`
- `sticker($to, $stickerUrl, $extra = [])`
- `contactCard($to, $contact, $extra = [])`
- `location($to, $latitude, $longitude, $name = null, $address = null, $extra = [])`
- `poll($to, $question, $options, $multiSelect = false, $extra = [])`
- `quoted($to, $text, $quoted, $extra = [])`
- `withMentions($to, $text, $mentions, $extra = [])`
- `viewOnce($to, $media, $extra = [])`

### إدارة الرسائل

```php
WasenderApi::messages()->info('MESSAGE_ID');
WasenderApi::messages()->edit('MESSAGE_ID', 'النص الجديد');
WasenderApi::messages()->delete('MESSAGE_ID');
WasenderApi::messages()->resend(100000);

WasenderApi::messages()->markAsRead([
    'id' => 'MESSAGE_ID',
    'remoteJid' => '123@s.whatsapp.net',
    'fromMe' => false,
]);
```

### رفع الوسائط وفك تشفيرها

```php
WasenderApi::messages()->uploadBase64(
    base64: 'data:image/png;base64,iVBORw0KGgo...'
);

WasenderApi::messages()->uploadBinary(
    path: storage_path('app/photo.jpg'),
    mimetype: 'image/jpeg'
);

WasenderApi::messages()->decryptMedia($payload['data']);
```

### إدارة الجلسات

```php
WasenderApi::sessions()->all();

WasenderApi::sessions()->create([
    'name' => 'Main WhatsApp',
    'webhook_url' => 'https://your-app.com/wasenderapi/webhook',
]);

WasenderApi::sessions()->get(1);
WasenderApi::sessions()->update(1, ['name' => 'Sales']);
WasenderApi::sessions()->connect(1);
WasenderApi::sessions()->qrCode(1);
WasenderApi::sessions()->restart(1);
WasenderApi::sessions()->disconnect(1);
WasenderApi::sessions()->delete(1);
WasenderApi::sessions()->messageLogs(1, ['page' => 1]);
WasenderApi::sessions()->logs(1);
WasenderApi::sessions()->regenerateApiKey(1);
```

عمليات جلسة API key:

```php
WasenderApi::sessions()->status();
WasenderApi::sessions()->user();
WasenderApi::sessions()->isOnWhatsApp('+1234567890');
WasenderApi::sessions()->sendPresenceUpdate('123@s.whatsapp.net', 'typing');
```

### جهات الاتصال

```php
WasenderApi::contacts()->all();
WasenderApi::contacts()->get('+1234567890');
WasenderApi::contacts()->picture('+1234567890');
WasenderApi::contacts()->block('+1234567890');
WasenderApi::contacts()->unblock('+1234567890');

WasenderApi::contacts()->createOrUpdate([
    'phone' => '+1234567890',
    'name' => 'Customer',
]);

WasenderApi::contacts()->lidFromPhoneNumber('+1234567890');
WasenderApi::contacts()->phoneNumberFromLid('lid-value');
```

### المجموعات

```php
WasenderApi::groups()->create('Team', ['+1234567890', '+1987654321']);
WasenderApi::groups()->all();
WasenderApi::groups()->metadata('120363xxxx@g.us');
WasenderApi::groups()->participants('120363xxxx@g.us');
WasenderApi::groups()->sendMessage('120363xxxx@g.us', 'رسالة للمجموعة');
WasenderApi::groups()->addParticipants('120363xxxx@g.us', ['+1234567890']);
WasenderApi::groups()->removeParticipants('120363xxxx@g.us', ['+1234567890']);
WasenderApi::groups()->updateParticipants('120363xxxx@g.us', ['+1234567890'], 'promote');
WasenderApi::groups()->picture('120363xxxx@g.us');
WasenderApi::groups()->inviteLink('120363xxxx@g.us');
WasenderApi::groups()->inviteInfo('INVITE_CODE');
WasenderApi::groups()->acceptInvite('INVITE_CODE');
WasenderApi::groups()->leave('120363xxxx@g.us');
```

### القنوات

```php
WasenderApi::channels()->sendMessage('120363xxxx@newsletter', 'رسالة للقناة');

WasenderApi::channels()->send([
    'to' => '120363xxxx@newsletter',
    'text' => 'رسالة مخصصة',
]);
```

### الويبهوكس

الحزمة تضيف مسارًا افتراضيًا:

```text
POST /wasenderapi/webhook
```

عند وصول webhook صحيح، تطلق الحزمة event باسم `WasenderWebhookReceived`:

```php
use Ashraf\WasenderApi\Events\WasenderWebhookReceived;
use Illuminate\Support\Facades\Event;

Event::listen(WasenderWebhookReceived::class, function (WasenderWebhookReceived $event) {
    logger()->info('Wasender event received', [
        'event' => $event->event,
        'data' => $event->data,
    ]);
});
```

لتغيير مسار الويبهوك:

```dotenv
WASENDERAPI_WEBHOOK_ROUTE_PATH=api/wasender/webhook
```

لتعطيل المسار الافتراضي وبناء controller خاص بك:

```dotenv
WASENDERAPI_WEBHOOK_ROUTE_ENABLED=false
```

### استخدام endpoint غير موجود كطريقة جاهزة

```php
WasenderApi::get('status');

WasenderApi::post('send-message', [
    'to' => '+1234567890',
    'text' => 'رسالة عامة',
]);

WasenderApi::put('contacts', [
    'phone' => '+1234567890',
    'name' => 'Ali',
]);

WasenderApi::delete('messages/MESSAGE_ID');
```

### التعامل مع الأخطاء

افتراضيًا، الحزمة ترمي `WasenderApiException` عند فشل الطلب:

```php
use Ashraf\WasenderApi\Exceptions\WasenderApiException;

try {
    WasenderApi::messages()->text('+1234567890', 'Hello');
} catch (WasenderApiException $exception) {
    report($exception);
}
```

لتعطيل رمي الاستثناءات:

```dotenv
WASENDERAPI_THROW=false
```

لإرجاع headers وحالة HTTP داخل الرد:

```dotenv
WASENDERAPI_INCLUDE_RESPONSE_HEADERS=true
```

### مشاكل شائعة

إذا ظهر خطأ minimum stability، استخدم نسخة مستقرة عبر tag:

```bash
composer require ashraf/wasenderapi-laravel:^1.1
```

أو استخدم الفرع مباشرة:

```bash
composer require ashraf/wasenderapi-laravel:dev-main
```

إذا لم يجد Composer الحزمة، تأكد من تعريف repository:

```bash
composer config repositories.wasenderapi-laravel vcs https://github.com/AshrafCodes/wasenderapi-laravel.git
```

### تشغيل الاختبارات

```bash
composer install
vendor/bin/phpunit
```

---

## English

### Overview

This package provides a Laravel-friendly wrapper for WasenderAPI. It lets you manage WhatsApp sessions, send messages, upload and decrypt media, work with contacts, groups, channels, and receive webhook events without writing raw HTTP requests in every project.

Basic usage:

```php
use Ashraf\WasenderApi\Facades\WasenderApi;

WasenderApi::messages()->text('+1234567890', 'Hello from Laravel');
```

### Requirements

- PHP 8.1 or higher
- Laravel 10, 11, 12, or 13
- Composer
- WasenderAPI account
- `Personal Access Token` for account/session management
- `Session API Key` for messaging and session-level operations

### Installation From GitHub

The package is not published on Packagist. Register the repository in your Laravel project first:

```bash
composer config repositories.wasenderapi-laravel vcs https://github.com/AshrafCodes/wasenderapi-laravel.git
composer require ashraf/wasenderapi-laravel:^1.1.0
or
composer require ashraf/wasenderapi-laravel:dev-main
```





Publish the configuration file:

```bash
php artisan vendor:publish --tag=wasenderapi-config
```

### Environment Configuration

Add these values to your Laravel `.env` file:

```dotenv
WASENDERAPI_BASE_URL=https://www.wasenderapi.com/api
WASENDERAPI_PERSONAL_ACCESS_TOKEN=your_personal_access_token
WASENDERAPI_API_KEY=your_session_api_key
WASENDERAPI_WEBHOOK_SECRET=your_webhook_secret
```

### Token Types

- `WASENDERAPI_PERSONAL_ACCESS_TOKEN`: Used for account-level session management, such as creating, listing, restarting, deleting sessions, and regenerating API keys.
- `WASENDERAPI_API_KEY`: Used for session-level actions, such as sending messages, checking status, contacts, groups, and channels.

The package automatically uses the proper token for the built-in methods.

### Send a Text Message

```php
use Ashraf\WasenderApi\Facades\WasenderApi;

WasenderApi::messages()->text('+1234567890', 'Hello from Laravel');
```

### Send an Image

```php
WasenderApi::messages()->image(
    to: '+1234567890',
    imageUrl: 'https://example.com/image.jpg',
    text: 'Image caption'
);
```

### Send a Video

```php
WasenderApi::messages()->video(
    to: '+1234567890',
    videoUrl: 'https://example.com/video.mp4',
    text: 'New video'
);
```

### Send a Document

```php
WasenderApi::messages()->document(
    to: '+1234567890',
    documentUrl: 'https://example.com/report.pdf',
    text: 'Report file',
    fileName: 'report.pdf'
);
```

### Send a Location

```php
WasenderApi::messages()->location(
    to: '+1234567890',
    latitude: 37.7749,
    longitude: -122.4194,
    name: 'Company HQ',
    address: 'San Francisco'
);
```

### Send a Poll

```php
WasenderApi::messages()->poll(
    to: '+1234567890',
    question: 'What is your favorite color?',
    options: ['Blue', 'Green', 'Red'],
    multiSelect: false
);
```

### Supported Message Methods

- `text($to, $text, $extra = [])`
- `image($to, $imageUrl, $text = null, $extra = [])`
- `video($to, $videoUrl, $text = null, $extra = [])`
- `document($to, $documentUrl, $text = null, $fileName = null, $extra = [])`
- `audio($to, $audioUrl, $extra = [])`
- `sticker($to, $stickerUrl, $extra = [])`
- `contactCard($to, $contact, $extra = [])`
- `location($to, $latitude, $longitude, $name = null, $address = null, $extra = [])`
- `poll($to, $question, $options, $multiSelect = false, $extra = [])`
- `quoted($to, $text, $quoted, $extra = [])`
- `withMentions($to, $text, $mentions, $extra = [])`
- `viewOnce($to, $media, $extra = [])`

### Message Management

```php
WasenderApi::messages()->info('MESSAGE_ID');
WasenderApi::messages()->edit('MESSAGE_ID', 'Updated text');
WasenderApi::messages()->delete('MESSAGE_ID');
WasenderApi::messages()->resend(100000);

WasenderApi::messages()->markAsRead([
    'id' => 'MESSAGE_ID',
    'remoteJid' => '123@s.whatsapp.net',
    'fromMe' => false,
]);
```

### Media Upload and Decryption

```php
WasenderApi::messages()->uploadBase64(
    base64: 'data:image/png;base64,iVBORw0KGgo...'
);

WasenderApi::messages()->uploadBinary(
    path: storage_path('app/photo.jpg'),
    mimetype: 'image/jpeg'
);

WasenderApi::messages()->decryptMedia($payload['data']);
```

### Session Management

```php
WasenderApi::sessions()->all();

WasenderApi::sessions()->create([
    'name' => 'Main WhatsApp',
    'webhook_url' => 'https://your-app.com/wasenderapi/webhook',
]);

WasenderApi::sessions()->get(1);
WasenderApi::sessions()->update(1, ['name' => 'Sales']);
WasenderApi::sessions()->connect(1);
WasenderApi::sessions()->qrCode(1);
WasenderApi::sessions()->restart(1);
WasenderApi::sessions()->disconnect(1);
WasenderApi::sessions()->delete(1);
WasenderApi::sessions()->messageLogs(1, ['page' => 1]);
WasenderApi::sessions()->logs(1);
WasenderApi::sessions()->regenerateApiKey(1);
```

Session API key methods:

```php
WasenderApi::sessions()->status();
WasenderApi::sessions()->user();
WasenderApi::sessions()->isOnWhatsApp('+1234567890');
WasenderApi::sessions()->sendPresenceUpdate('123@s.whatsapp.net', 'typing');
```

### Contacts

```php
WasenderApi::contacts()->all();
WasenderApi::contacts()->get('+1234567890');
WasenderApi::contacts()->picture('+1234567890');
WasenderApi::contacts()->block('+1234567890');
WasenderApi::contacts()->unblock('+1234567890');

WasenderApi::contacts()->createOrUpdate([
    'phone' => '+1234567890',
    'name' => 'Customer',
]);

WasenderApi::contacts()->lidFromPhoneNumber('+1234567890');
WasenderApi::contacts()->phoneNumberFromLid('lid-value');
```

### Groups

```php
WasenderApi::groups()->create('Team', ['+1234567890', '+1987654321']);
WasenderApi::groups()->all();
WasenderApi::groups()->metadata('120363xxxx@g.us');
WasenderApi::groups()->participants('120363xxxx@g.us');
WasenderApi::groups()->sendMessage('120363xxxx@g.us', 'Group message');
WasenderApi::groups()->addParticipants('120363xxxx@g.us', ['+1234567890']);
WasenderApi::groups()->removeParticipants('120363xxxx@g.us', ['+1234567890']);
WasenderApi::groups()->updateParticipants('120363xxxx@g.us', ['+1234567890'], 'promote');
WasenderApi::groups()->picture('120363xxxx@g.us');
WasenderApi::groups()->inviteLink('120363xxxx@g.us');
WasenderApi::groups()->inviteInfo('INVITE_CODE');
WasenderApi::groups()->acceptInvite('INVITE_CODE');
WasenderApi::groups()->leave('120363xxxx@g.us');
```

### Channels

```php
WasenderApi::channels()->sendMessage('120363xxxx@newsletter', 'Channel message');

WasenderApi::channels()->send([
    'to' => '120363xxxx@newsletter',
    'text' => 'Custom channel message',
]);
```

### Webhooks

The package registers this default webhook endpoint:

```text
POST /wasenderapi/webhook
```

When a valid webhook is received, the package dispatches `WasenderWebhookReceived`:

```php
use Ashraf\WasenderApi\Events\WasenderWebhookReceived;
use Illuminate\Support\Facades\Event;

Event::listen(WasenderWebhookReceived::class, function (WasenderWebhookReceived $event) {
    logger()->info('Wasender event received', [
        'event' => $event->event,
        'data' => $event->data,
    ]);
});
```

To change the webhook route:

```dotenv
WASENDERAPI_WEBHOOK_ROUTE_PATH=api/wasender/webhook
```

To disable the default route and use your own controller:

```dotenv
WASENDERAPI_WEBHOOK_ROUTE_ENABLED=false
```

### Calling Custom Endpoints

If WasenderAPI adds an endpoint that does not have a dedicated method yet, use the generic HTTP helpers:

```php
WasenderApi::get('status');

WasenderApi::post('send-message', [
    'to' => '+1234567890',
    'text' => 'Generic message',
]);

WasenderApi::put('contacts', [
    'phone' => '+1234567890',
    'name' => 'Ali',
]);

WasenderApi::delete('messages/MESSAGE_ID');
```

### Error Handling

By default, failed requests throw `WasenderApiException`:

```php
use Ashraf\WasenderApi\Exceptions\WasenderApiException;

try {
    WasenderApi::messages()->text('+1234567890', 'Hello');
} catch (WasenderApiException $exception) {
    report($exception);
}
```

To disable exceptions:

```dotenv
WASENDERAPI_THROW=false
```

To include HTTP status and response headers in the returned array:

```dotenv
WASENDERAPI_INCLUDE_RESPONSE_HEADERS=true
```

### Troubleshooting

If Composer reports a minimum stability error, install a stable tag:

```bash
composer require ashraf/wasenderapi-laravel:^1.1
```

Or require the main branch:

```bash
composer require ashraf/wasenderapi-laravel:dev-main
```

If Composer cannot find the package, make sure the GitHub repository is registered:

```bash
composer config repositories.wasenderapi-laravel vcs https://github.com/AshrafCodes/wasenderapi-laravel.git
```

### Testing

```bash
composer install
vendor/bin/phpunit
```

---

## Official WasenderAPI Documentation

- [API Docs](https://wasenderapi.com/api-docs)
- [Laravel SDK Docs](https://wasenderapi.com/api-docs/developer-sdks/official-sdks-nodejs-python-laravel)
- [Authentication](https://wasenderapi.com/api-docs/authentication/how-to-authenticate-api-requests-using-personal-access-token)
- [Webhook Setup](https://wasenderapi.com/api-docs/webhooks/webhook-setup)

## License

MIT
