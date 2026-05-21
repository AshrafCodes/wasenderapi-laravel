<?php

namespace Ashraf\WasenderApi\Resources;

class ContactsApi extends AbstractResource
{
    public function all(array $query = []): array
    {
        return $this->client->usingApiKey()->get('contacts', $query);
    }

    public function get(string $phoneNumber): array
    {
        return $this->client->usingApiKey()->get('contacts/' . rawurlencode($phoneNumber));
    }

    public function picture(string $phoneNumber): array
    {
        return $this->client->usingApiKey()->get('contacts/' . rawurlencode($phoneNumber) . '/picture');
    }

    public function block(string $phoneNumber): array
    {
        return $this->client->usingApiKey()->post('contacts/' . rawurlencode($phoneNumber) . '/block');
    }

    public function unblock(string $phoneNumber): array
    {
        return $this->client->usingApiKey()->post('contacts/' . rawurlencode($phoneNumber) . '/unblock');
    }

    public function createOrUpdate(array $payload): array
    {
        return $this->client->usingApiKey()->put('contacts', $payload);
    }

    public function lidFromPhoneNumber(string $phoneNumber): array
    {
        return $this->client->usingApiKey()->get('lid-from-pn/' . rawurlencode($phoneNumber));
    }

    public function phoneNumberFromLid(string $lid): array
    {
        return $this->client->usingApiKey()->get('pn-from-lid/' . rawurlencode($lid));
    }
}
