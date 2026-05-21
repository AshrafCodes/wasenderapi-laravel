<?php

namespace Ashraf\WasenderApi\Resources;

class GroupsApi extends AbstractResource
{
    public function create(string $name, array $participants, array $extra = []): array
    {
        return $this->client->usingApiKey()->post('groups', array_merge($extra, compact('name', 'participants')));
    }

    public function all(array $query = []): array
    {
        return $this->client->usingApiKey()->get('groups', $query);
    }

    public function metadata(string $groupJid): array
    {
        return $this->client->usingApiKey()->get("groups/{$groupJid}/metadata");
    }

    public function sendMessage(string $groupJid, string $text, array $extra = []): array
    {
        return $this->client->usingApiKey()->post('send-message', array_merge($extra, [
            'to' => $groupJid,
            'text' => $text,
        ]));
    }

    public function participants(string $groupJid): array
    {
        return $this->client->usingApiKey()->get("groups/{$groupJid}/participants");
    }

    public function updateParticipants(string $groupId, array $participants, string $action, array $extra = []): array
    {
        return $this->client->usingApiKey()->put("groups/{$groupId}/participants/update", array_merge($extra, compact('participants', 'action')));
    }

    public function addParticipants(string $groupJid, array $participants): array
    {
        return $this->client->usingApiKey()->post("groups/{$groupJid}/participants/add", compact('participants'));
    }

    public function removeParticipants(string $groupJid, array $participants): array
    {
        return $this->client->usingApiKey()->post("groups/{$groupJid}/participants/remove", compact('participants'));
    }

    public function picture(string $groupJid): array
    {
        return $this->client->usingApiKey()->get("groups/{$groupJid}/picture");
    }

    public function updateSettings(string $groupJid, array $settings): array
    {
        return $this->client->usingApiKey()->put("groups/{$groupJid}/settings", $settings);
    }

    public function inviteLink(string $groupJid): array
    {
        return $this->client->usingApiKey()->get("groups/{$groupJid}/invite-link");
    }

    public function inviteInfo(string $inviteCode): array
    {
        return $this->client->usingApiKey()->get("groups/invite/{$inviteCode}");
    }

    public function acceptInvite(string $inviteCode): array
    {
        return $this->client->usingApiKey()->post('groups/invite/accept', compact('inviteCode'));
    }

    public function leave(string $groupId): array
    {
        return $this->client->usingApiKey()->post("groups/{$groupId}/leave");
    }
}
