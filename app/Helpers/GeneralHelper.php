<?php

namespace App\Helpers;

//use App\Mail\MailsHandler;
//use DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Class GeneralHelper
 *
 * @package App\Helpers
 */
abstract class GeneralHelper
{

    # Messages
    const ERROR_MESSAGE = 'Something went wrong.';

    /**
     * Identify Current User
     *
     * @param null $user
     *
     * @return mixed|null
     */
    public static function WHO_AM_I($user = null)
    {
        if($user != null)
            return self::GET_ROLE($user);

        $guards = config('auth.guards');
        foreach ($guards as $guard => $value)
            if(Auth::guard($guard)->check())
                return $guard;

        return null;
    }

    /**
     * Get User Role String
     *
     * @param null $user
     *
     * @return string
     */
    public static function GET_ROLE_STRING($user = null)
    {
        $role = self::WHO_AM_I($user);
        return ucwords(str_replace('_', ' ', $role));
    }

    /**
     * Get Role
     *
     * @param $user
     *
     * @return string
     */
    public static function GET_ROLE($user)
    {
        if($user->hasRole('super-admin'))
            return 'super-admin';

        if($user->hasRole('sub-admin'))
            return 'sub-admin';

        if($user->hasRole('user'))
            return 'user';

        return 'undefined';
    }

    /**
     * Get Events Types
     *
     * @return array
     */
    public static function GET_EVENT_TYPES()
    {
        return [
            IEventType::EVENT       => 'Event',
            IEventType::SEMINAR     => 'Seminar',
            IEventType::APPOINTMENT => 'Appointment',
        ];
    }

    /**
     * Get Reminder Types
     *
     * @return array
     */
    public static function GET_REMINDER_TYPES()
    {
        return [
            IReminderType::SINGLE   => 'Single',
            IReminderType::MULTIPLE => 'Multiple',
        ];
    }

    /**
     * Get Roles
     *
     * @return string[]
     */
    public static function GET_ROLES()
    {
        return [
            IUserType::ADMIN    => 'Admin',
            IUserType::SELLER   => 'Upline',
            IUserType::CONSUMER => 'Downline',
        ];
    }

    /**
     * Get Permissions
     *
     * @return string[]
     */
    public static function GET_PERMISSIONS()
    {
        return [
            IUserPermission::SELLER => 'Seller',
            IUserPermission::CONSUMER => 'Consumer'
        ];
    }

    /**
     * Get Roles
     *
     * @return string[]
     */
    public static function GET_GENDER()
    {
        return [
            'male'   => 'Male',
            'female' => 'Female',
        ];
    }

    public static function PAGINATION_SIZE()
    {
        return 10;
    }

    /**
     * Check For Authentication
     *
     * @return bool
     */
    public static function IS_AUTHENTICATED(): bool
    {
        return Auth::guard(self::WHO_AM_I())->check();
    }

    /**
     * Check For SuperAdmin
     *
     * @param null $user
     * @return bool
     */
    public static function IS_SUPER_ADMIN($user = null): bool
    {
        if($user)
            return $user->hasRole(['super-admin']);
        return Auth::user()->hasRole(['super-admin']);
    }

    /**
     * Check For SuperAdmin
     *
     * @param null $user
     * @return bool
     */
    public static function IS_SUB_ADMIN($user = null): bool
    {
        if($user)
            return $user->hasRole(['sub-admin']);
        return Auth::user()->hasRole(['sub-admin']);
    }

    /**
     * Check For SuperAdmin
     *
     * @param null $user
     * @return bool
     */
    public static function IS_USER($user = null): bool
    {
        if($user)
            return $user->hasRole(['user']);
        return Auth::user()->hasRole(['user']);
    }

    /**
     * Check For Seller (Upline)
     *
     * @return bool
     */
    public static function IS_SELLER(): bool
    {
        return Auth::guard(IUserRole::SELLER)->check();
    }

    /**
     * Check For Consumer (Downline)
     *
     * @return bool
     */
    public static function IS_CONSUMER(): bool
    {
        return Auth::guard(IUserRole::CONSUMER)->check();
    }

    /**
     * Check User Permission
     *
     * @param string $permission
     *
     * @return bool
     */
    public static function HAS_PERMISSION(string $permission): bool
    {
        $user = self::USER();
        foreach ($user->permissions()->get() as $u_permission) {
            if($u_permission->permission === $permission)
                return true;
        }

        return false;
    }

    /**
     * Get Current User
     *
     * @param mixed ...$key
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|string|null
     */
    public static function USER(...$key)
    {

        $user = Auth::guard(self::WHO_AM_I())->user();

        if(count($key) > 0)
        {
            $bind = [];
            foreach ($key as $item)
                array_push($bind, $user->{$item} ?? null);

            return implode(' ', $bind);
        }

        return $user;
    }

    /**
     * Redirection Rules
     *
     * @return string|null
     */
    public static function REDIRECT_TO()
    {
        $route = null;
        if(self::IS_AUTHENTICATED())
            return sprintf("%s.index", self::WHO_AM_I());

        return back();
    }

    /**
     * Select Field Setup
     *
     * @param $data
     * @param string $key
     * @param mixed ...$value
     *
     * @return array
     */
    public static function SELECT_FIELD($data, string $key, ...$value)
    {
        $collection = [];
        if(is_object($data) || is_array($data))
            foreach ($data as $index => $item)
            {
                $valueString = [];
                foreach ($value as $item2)
                    array_push($valueString, $item->{$item2});

                $collection[$item->{$key}] = implode(' | ', $valueString);
            }

        return $collection;
    }

    /**
     * Upload Given File
     *
     * @param object $file
     * @param string $path
     * @param bool   $rename
     * @param bool   $unlink
     * @param string|null $oldPath
     *
     * @return bool|string
     */
    public static function UPLOAD_FILE(object $file, string $path, $rename = true, bool $unlink = false, string $oldPath = null)
    {
        $name = $rename ? time() . '.' . $file->getClientOriginalExtension() : $file->getClientOriginalName();
        if(self::MAKE_DIR($path))
        {
            Storage::disk('public')->putFileAs($path, $file, $name);
            $full_image_name = 'storage/' . $path . '/' . $name;
            !$unlink ?: self::REMOVE_FILE($oldPath);
            return $full_image_name;
        }

        return false;
    }

    /**
     * Write File
     *
     * @param $path
     * @param $content
     *
     * @return string
     */
    public static function WRITE_FILE($path, $content)
    {
        $name = sprintf("%s/%s.txt", $path, self::STR_RANDOM(10));
        Storage::disk('public')->put($name, $content);
        return $name;
    }

    /**
     * Read File
     *
     * @param $fileName
     *
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function READ_FILE($fileName)
    {
        return Storage::disk('public')->get($fileName);
    }

    /**
     * Upload Multiple Images
     *
     * @param array $files
     * @param string $path
     *
     * @return array
     */
    public static function UPLOAD_MULTIPLE_FILES(array $files, string $path): array
    {
        $collection = [];
        foreach ($files as $file) {
            array_push($collection, self::UPLOAD_FILE($file, $path));
        }

        return $collection;
    }

    /**
     * Create New Directory
     *
     * @param string $name
     *
     * @return bool
     */
    public static function MAKE_DIR(string $name): bool
    {
        if (!Storage::disk('public')->exists($name)) {
            Storage::disk('public')->makeDirectory($name);
        }

        return true;
    }

    /**
     * Remove Existing File
     *
     * @param string $filepath
     *
     * @return bool
     */
    public static function REMOVE_FILE(string $filepath): bool
    {
        return @unlink( $filepath ?? '' );
    }

    /**
     * JS Toast Message
     *
     * @param string $type
     * @param string $message
     *
     * @return string
     */
    public static function TOAST(string $type, string $message)
    {
        return sprintf("<script>toastr.%s('%s');</script>", $type, $message);
    }

    /**
     * Success Response
     *
     * @param $data
     * @param $route
     * @param $sucMsg
     *
     * @return RedirectResponse
     */
    public static function SUCCESS($data, $route, $sucMsg)
    {

        $res = [
            'message'    => $sucMsg,
            'alert_type' => 'success',
            'data'       => $data
        ];

        return $route
            ? redirect()->route($route)->with($res)
            : redirect()->back()->with($res);
    }

    /**
     * Error Response
     *
     * @param $data
     * @param $route
     * @param $errMsg
     *
     * @return RedirectResponse
     */
    public static function ERROR($data, $route, $errMsg)
    {
        $data = [
            'message'    => $errMsg ?? self::ERROR_MESSAGE,
            'alert_type' => 'error',
            'data'       => $data
        ];

        return $route
            ? redirect()->route($route)->with($data)
            : redirect()->back()->with($data);
    }

    /**
     * User Request Response
     *
     * @param Request $request
     * @param         $data
     * @param string|null $sucMsg
     * @param string|null $route
     * @param string|null $errMsg
     *
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public static function SEND_RESPONSE(Request $request, $data, string $route = null, string $sucMsg = null, string $errMsg = null)
    {
        // Send Api Response
        if($request->ajax())
        {
            return $data
                ? response()->json([
                    'message'    => $sucMsg,
                    'status'     => true,
                    'alert_type' => 'success',
                    'data'       => $data,
                    'url'        => $route ? route($route) : null
                ])
                : response()->json([
                    'message'    => $errMsg ?? 'Something went wrong.',
                    'status'     => false,
                    'alert_type' => 'error',
                    'data'       => $data,
                    'url'        => $route ? route($route) : null
                ]);
        }

        // Send Web Response
        return $data
            ? self::SUCCESS($data, $route ?? null, $sucMsg)
            : self::ERROR($data, $route ?? null, $errMsg);
    }

    /**
     * @param $data
     *
     * @return mixed
     *
     */
    public static function SET_DATATABLE($data)
    {
        try {
            return datatables()->of($data)->toJson();
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * Dispatch Mail Job
     *
     * @param $data
     *
     * @return bool|mixed
     */
    public static function DISPATCH_MAIL( $data )
    {
        return Mail::to($data['to'])->send(new MailsHandler($data));
    }

    public static function mail($data, $to_name, $to_email, $view)
    {
        Mail::send($view, $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Contact Us Email');
            $message->from('wbinkhalid786@gmail.com','Contact Us Email');
        });
    }

    /**
     * Limit A String
     *
     * @param string|null $string $string
     * @param int $limit
     * @param string|null $end
     *
     * @return string
     */
    public static function STR_LIMIT(string $string = null, int $limit = 50, string $end = null)
    {

        if($string === null)
            return '';

        if(strlen($string) > $limit)
            return sprintf("%s %s", substr($string, 0, $limit), $end);

        return $string;
    }

    /**
     * Generate Random String
     *
     * @param $length
     *
     * @return string
     */
    public static function STR_RANDOM($length)
    {
        return Str::random($length);
    }

}
