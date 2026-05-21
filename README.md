# WasenderAPI Laravel Package

حزمة Laravel جاهزة للتعامل مع WasenderAPI: إدارة جلسات واتساب، إرسال الرسائل بكل أنواعها، رفع وفك تشفير الوسائط، جهات الاتصال، المجموعات، القنوات، والويبهوكس.

تم بناء الحزمة بالاعتماد على توثيق WasenderAPI الرسمي:

- API docs: https://wasenderapi.com/api-docs
- Laravel SDK page: https://wasenderapi.com/api-docs/developer-sdks/official-sdks-nodejs-python-laravel
- Authentication: https://wasenderapi.com/api-docs/authentication/how-to-authenticate-api-requests-using-personal-access-token
- Webhooks: https://wasenderapi.com/api-docs/webhooks/webhook-setup

## التثبيت داخل مشروع Laravel

إذا أردت استخدامها من هذا المجلد المحلي مباشرة داخل أي مشروع Laravel:

```bash
composer config repositories.wasenderapi-laravel '{"type":"path","url":"/Users/ashraf/Documents/plugin demo","options":{"symlink":true}}'
composer require ashraf/wasenderapi-laravel:*
```

ثم انشر ملف الإعدادات:

```bash
php artisan vendor:publish --tag=wasenderapi-config
```

أضف القيم إلى ملف `.env`:

```dotenv
WASENDERAPI_BASE_URL=https://www.wasenderapi.com/api
WASENDERAPI_PERSONAL_ACCESS_TOKEN=your_personal_access_token
WASENDERAPI_API_KEY=your_session_api_key
WASENDERAPI_WEBHOOK_SECRET=your_webhook_secret
```

## الفرق بين المفاتيح

WasenderAPI يستخدم نوعين من التوكنات:

- `Personal Access Token`: لإدارة الحساب والجلسات مثل إنشاء الجلسات وحذفها وعرضها.
- `API Key`: لإرسال الرسائل وقراءة حالة الجلسة والتعامل مع جهات الاتصال والمجموعات.

الحزمة تختار التوكن المناسب تلقائيًا في الطرق الجاهزة. ويمكنك فرض توكن محدد:

```php
use Ashraf\WasenderApi\Facades\WasenderApi;

$api = WasenderApi::withToken('custom-token');
```

## إرسال الرسائل

```php
WasenderApi::messages()->text('+1234567890', 'مرحبا من Laravel');

WasenderApi::messages()->image(
    to: '+1234567890',
    imageUrl: 'https://example.com/image.jpg',
    text: 'صورة مع تعليق'
);

WasenderApi::messages()->document(
    to: '+1234567890',
    documentUrl: 'https://example.com/report.pdf',
    text: 'التقرير',
    fileName: 'report.pdf'
);

WasenderApi::messages()->poll(
    to: '+1234567890',
    question: 'ما اللون المفضل؟',
    options: ['Blue', 'Green', 'Red'],
    multiSelect: false
);
```

أنواع الرسائل المدعومة:

- `text($to, $text, $extra = [])`
- `image($to, $imageUrl, $text = null, $extra = [])`
- `video($to, $videoUrl, $text = null, $extra = [])`
- `document($to, $documentUrl, $text = null, $fileName = null, $extra = [])`
- `audio($to, $audioUrl, $extra = [])`
- `sticker($to, $stickerUrl, $extra = [])`
- `contactCard($to, ['name' => 'Support', 'phone' => '+1234567890'])`
- `location($to, 37.7749, -122.4194, 'Company HQ', 'Address')`
- `poll($to, $question, $options, $multiSelect = false)`
- `quoted($to, $text, $quoted, $extra = [])`
- `withMentions($to, $text, $mentions, $extra = [])`
- `viewOnce($to, ['imageUrl' => 'https://example.com/image.jpg'])`

## الوسائط

```php
// رفع Base64
WasenderApi::messages()->uploadBase64(
    base64: 'data:image/png;base64,iVBORw0KGgo...',
);

// رفع ملف ثنائي
WasenderApi::messages()->uploadBinary(
    path: storage_path('app/photo.jpg'),
    mimetype: 'image/jpeg'
);

// فك تشفير وسائط واردة من webhook
WasenderApi::messages()->decryptMedia($payload['data']);
```

## إدارة الرسائل

```php
WasenderApi::messages()->info('MESSAGE_ID');
WasenderApi::messages()->edit('MESSAGE_ID', 'النص الجديد');
WasenderApi::messages()->delete('MESSAGE_ID');
WasenderApi::messages()->resend(100000);

WasenderApi::messages()->markAsRead([
    'id' => '3EB06A5E244031B4A5D1',
    'remoteJid' => '123@s.whatsapp.net',
    'fromMe' => false,
]);
```

## الجلسات

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

طرق جلسة API key:

```php
WasenderApi::sessions()->status();
WasenderApi::sessions()->user();
WasenderApi::sessions()->isOnWhatsApp('+1234567890');
WasenderApi::sessions()->sendPresenceUpdate('123@s.whatsapp.net', 'typing');
```

## جهات الاتصال

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

## المجموعات

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
WasenderApi::groups()->updateSettings('120363xxxx@g.us', [
    'subject' => 'New subject',
    'description' => 'New description',
]);
WasenderApi::groups()->inviteLink('120363xxxx@g.us');
WasenderApi::groups()->inviteInfo('INVITE_CODE');
WasenderApi::groups()->acceptInvite('INVITE_CODE');
WasenderApi::groups()->leave('120363xxxx@g.us');
```

## القنوات

```php
WasenderApi::channels()->sendMessage('120363xxxx@newsletter', 'رسالة للقناة');
WasenderApi::channels()->send([
    'to' => '120363xxxx@newsletter',
    'text' => 'رسالة مخصصة',
]);
```

## الويبهوكس

الحزمة تضيف مسارًا افتراضيًا:

```text
POST /wasenderapi/webhook
```

عند وصول webhook صحيح، يتم إطلاق event:

```php
use Ashraf\WasenderApi\Events\WasenderWebhookReceived;

Event::listen(WasenderWebhookReceived::class, function (WasenderWebhookReceived $event) {
    logger()->info('Wasender event received', [
        'event' => $event->event,
        'data' => $event->data,
    ]);
});
```

إذا أردت تغيير المسار:

```dotenv
WASENDERAPI_WEBHOOK_ROUTE_PATH=api/wasender/webhook
```

أو تعطيله وبناء controller خاص بك:

```dotenv
WASENDERAPI_WEBHOOK_ROUTE_ENABLED=false
```

## استدعاء أي endpoint غير موجود كطريقة جاهزة

```php
WasenderApi::get('status');
WasenderApi::post('send-message', [
    'to' => '+1234567890',
    'text' => 'رسالة عامة',
]);
WasenderApi::put('contacts', ['phone' => '+1234567890', 'name' => 'Ali']);
WasenderApi::delete('messages/MESSAGE_ID');
```

تستطيع تمرير endpoint مع `/api` أو بدونها؛ الحزمة تنظفه تلقائيًا:

```php
WasenderApi::post('/api/send-message', [...]);
```

## الأخطاء والـ rate limits

افتراضيًا الحزمة ترمي `WasenderApiException` عند أي استجابة فاشلة. لتعطيل ذلك:

```dotenv
WASENDERAPI_THROW=false
```

لإرجاع headers مثل rate limit داخل الرد:

```dotenv
WASENDERAPI_INCLUDE_RESPONSE_HEADERS=true
```

## تشغيل الاختبارات

```bash
composer install
vendor/bin/phpunit
```
