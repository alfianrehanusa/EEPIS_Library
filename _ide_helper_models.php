<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Buku
 *
 * @property int $id
 * @property string $judul
 * @property string $tahun
 * @property string $pengarang
 * @property string $sinopsis
 * @property int|null $jumlah
 * @property string $type_buku
 * @property string $gambar
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buku newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buku newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buku query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buku whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buku whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buku whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buku whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buku whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buku whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buku wherePengarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buku whereSinopsis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buku whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buku whereTypeBuku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Buku whereUpdatedAt($value)
 */
	class Buku extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $nama
 * @property string $email
 * @property string $password
 * @property string $user_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUserType($value)
 */
	class User extends \Eloquent {}
}

