<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Article
 *
 * @property int $id
 * @property string $reference
 * @property string|null $description
 * @property string $type
 * @property int|null $category_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Category|null $category
 * @property-read \App\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Document[] $document
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Article onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Article withoutTrashed()
 */
	class Article extends \Eloquent {}
}

namespace App{
/**
 * App\Business
 *
 * @property int $id
 * @property string $name
 * @property string $reference
 * @property string|null $description
 * @property int $company_id
 * @property int|null $contact_id
 * @property string $created_by_username
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\BusinessComment[] $businessComment
 * @property-read \App\Company $company
 * @property-read \App\Contact|null $contact
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $order
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Business onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereCreatedByUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Business withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Business withoutTrashed()
 */
	class Business extends \Eloquent {}
}

namespace App{
/**
 * App\BusinessComment
 *
 * @property int $id
 * @property string $content
 * @property int $business_id
 * @property int $created_by_user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Business $business
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BusinessComment whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BusinessComment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BusinessComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BusinessComment whereCreatedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BusinessComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BusinessComment whereUpdatedAt($value)
 */
	class BusinessComment extends \Eloquent {}
}

namespace App{
/**
 * App\Category
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Article[] $articles
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Category onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Category withoutTrashed()
 */
	class Category extends \Eloquent {}
}

namespace App{
/**
 * App\Company
 *
 * @property int $id
 * @property string $name
 * @property string $status
 * @property string|null $description
 * @property string $created_by_username
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Business[] $business
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\BusinessComment[] $businessComment
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contact[] $contact
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Company onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereCreatedByUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Company withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Company withoutTrashed()
 */
	class Company extends \Eloquent {}
}

namespace App{
/**
 * App\Contact
 *
 * @property int $id
 * @property string $name
 * @property string $address_line1
 * @property string|null $address_line2
 * @property string $zip
 * @property string $city
 * @property string|null $phone_number
 * @property string|null $fax
 * @property string $email
 * @property int|null $company_id
 * @property string $created_by_username
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Business[] $business
 * @property-read \App\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Delivery[] $delivery
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Contact onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereCreatedByUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereZip($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contact withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Contact withoutTrashed()
 */
	class Contact extends \Eloquent {}
}

namespace App{
/**
 * App\Delivery
 *
 * @property int $id
 * @property int $order_id
 * @property int $contact_id
 * @property string|null $internal_comment
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Contact $contact
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DeliveryComment[] $deliveryComment
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Document[] $document
 * @property-read \App\Order $order
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereInternalComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery withoutTrashed()
 */
	class Delivery extends \Eloquent {}
}

namespace App{
/**
 * App\DeliveryComment
 *
 * @property int $id
 * @property string $content
 * @property int $delivery_id
 * @property int $created_by_user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Delivery $delivery
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryComment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryComment whereCreatedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryComment whereDeliveryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryComment whereUpdatedAt($value)
 */
	class DeliveryComment extends \Eloquent {}
}

namespace App{
/**
 * App\Document
 *
 * @property int $id
 * @property string $file_name
 * @property string $file_path
 * @property string $mime_type
 * @property int $quantity
 * @property string $rolled_folded_flat
 * @property int $length
 * @property int $width
 * @property int $nb_orig
 * @property int $free
 * @property int $format_id
 * @property int|null $delivery_id
 * @property int $article_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Article $articles
 * @property-read \App\Delivery|null $delivery
 * @property-read \App\Format $format
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereDeliveryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereFormatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereNbOrig($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereRolledFoldedFlat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereWidth($value)
 */
	class Document extends \Eloquent {}
}

namespace App{
/**
 * App\Format
 *
 * @property int $id
 * @property string $name
 * @property int $height
 * @property int $width
 * @property float|null $surface
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Document[] $document
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Format onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Format whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Format whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Format whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Format whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Format whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Format whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Format whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Format whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Format withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Format withoutTrashed()
 */
	class Format extends \Eloquent {}
}

namespace App{
/**
 * App\Order
 *
 * @property int $id
 * @property string $reference
 * @property string $status
 * @property int $business_id
 * @property int $contact_id
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Business $business
 * @property-read \App\Contact $contact
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Delivery[] $delivery
 * @property-read \App\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Order onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Order withoutTrashed()
 */
	class Order extends \Eloquent {}
}

namespace App{
/**
 * App\Profile
 *
 */
	class Profile extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $role
 * @property string $email
 * @property bool $confirmed
 * @property string|null $confirmation_token
 * @property int|null $contact_id
 * @property int|null $company_id
 * @property int $contact_confirmed
 * @property int $company_confirmed
 * @property int $was_invited
 * @property string|null $remember_token
 * @property string|null $last_login_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Business[] $business
 * @property-read \App\Company|null $company
 * @property-read \App\Contact|null $contact
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DeliveryComment[] $deliveryComment
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $order
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCompanyConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereConfirmationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereContactConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereWasInvited($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\User withoutTrashed()
 */
	class User extends \Eloquent {}
}

