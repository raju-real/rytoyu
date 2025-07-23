<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class BlockIllegalProducts implements Scope
{
    protected $bannedKeywords = [
        // Illegal drugs
        'cocaine', 'heroin', 'mdma', 'lsd', 'meth', 'weed', 'marijuana', 'opium',

        // Weapons
        'gun', 'pistol', 'rifle', 'shotgun', 'ammunition', 'bullet', 'explosive', 'bomb', 'grenade',

        // Counterfeit
        'fake passport', 'fake id', 'counterfeit', 'forged document', 'fake currency',

        // Human trafficking / organs
        'human trafficking', 'child labor', 'organ trade', 'kidney for sale',

        // Hateful or abusive
        'nazi', 'racist', 'terrorist', 'hitman', 'murder for hire',

        // Pornographic
        'porn', 'sex toy', 'adult dvd', 'erotic', 'xxx', 'nude', 'fetish',

        // Animals / wildlife illegal trade
        'ivory', 'rhino horn', 'tiger bone', 'animal trophy', 'endangered species',

        // Dangerous chemicals
        'cyanide', 'mercury', 'arsenic', 'poison',

        // Others
        'hacking tools', 'cheat software', 'pirated', 'torrent', 'keygen', 'serial number', 'cracker',
    ];

    public function apply(Builder $builder, Model $model)
    {
        foreach ($this->bannedKeywords as $keyword) {
            $builder->where('name', 'NOT LIKE', "%$keyword%");
        }
    }
}

