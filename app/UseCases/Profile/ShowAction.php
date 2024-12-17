<?php

namespace App\UseCases\Profile;

use App\Models\Profile;

class ShowAction
{
    /**
     * IDからProfileModelの取得.
     *
     * @param string $id
     * @return Profile
     */
    public function handle(string $id): Profile
    {
        return Profile::findOrFail($id);
    }
}
