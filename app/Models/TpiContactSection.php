<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class TpiContactSection extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];

    protected $casts = [
        'phone_cards' => 'array',
        'social_card' => 'array',
        'email_cards' => 'array',
        'is_active' => 'boolean',
    ];

    public static function getContent()
    {
        return static::query()->where('is_active', true)->first();
    }

    public function getPhoneCardsList(): array
    {
        if (empty($this->phone_cards) || !is_array($this->phone_cards)) {
            return static::getDefaultPhoneCards();
        }
        return $this->phone_cards;
    }

    public function getSocialCard(): array
    {
        if (empty($this->social_card) || !is_array($this->social_card)) {
            return static::getDefaultSocialCard();
        }
        return $this->social_card;
    }

    public function getEmailCardsList(): array
    {
        if (empty($this->email_cards) || !is_array($this->email_cards)) {
            return static::getDefaultEmailCards();
        }
        return $this->email_cards;
    }

    public static function getDefaultPhoneCards(): array
    {
        return [
            ['icon' => 'bi-headset', 'flag' => 'flag-icon-us', 'lang_tag' => '(EN)', 'phone_number' => '+96896564491', 'phone_display' => '+968 96564491/92'],
            ['icon' => 'bi-headset', 'flag' => 'flag-icon-eg', 'lang_tag' => '(AR)', 'phone_number' => '+201203339715', 'phone_display' => '+20 1203339715/16'],
            ['icon' => 'bi-headset', 'flag' => 'flag-icon-ru', 'lang_tag' => '(RU)', 'phone_number' => '+998908227560', 'phone_display' => '+998 908227560/1'],
        ];
    }

    public static function getDefaultSocialCard(): array
    {
        return [
            'icon' => 'bi-chat-dots',
            'title' => 'Social Media',
            'links' => [
                ['label' => 'WhatsApp', 'url' => 'https://wa.me/998908227561', 'icon_class' => 'whatsapp', 'bi_icon' => 'bi-whatsapp'],
                ['label' => 'Telegram', 'url' => 'https://t.me/+998908227561', 'icon_class' => 'telegram', 'bi_icon' => 'bi-telegram'],
            ],
        ];
    }

    public static function getDefaultEmailCards(): array
    {
        return [
            ['icon' => 'bi-headset', 'title' => 'Customer Service', 'email' => 'cs@nen-global.org'],
            ['icon' => 'bi-tools', 'title' => 'Technical Support', 'email' => 'support@nen-global.org'],
            ['icon' => 'bi-award', 'title' => 'Accreditation', 'email' => 'acc@nen-global.org'],
            ['icon' => 'bi-globe', 'title' => 'International Testing', 'email' => 'tca@nen-global.org'],
        ];
    }
}
