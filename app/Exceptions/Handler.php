<?php

namespace App\Exceptions;

use App\Models\User;
use App\Traits\UserCurrentLanguageTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    use UserCurrentLanguageTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [

    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        //check if exception is an instance of ModelNotFoundException.
        if ($exception instanceof ModelNotFoundException) {
            // normal 404 view page feedback
            // path based user URL
            if ((str_replace("www.","",$request->getHost()) == env('WEBSITE_HOST') && str_contains(Request::route()->getPrefix(), '{username}'))) {
                $user = User::query()->where('username', Request::route('username'));

                if ($user->count() > 0) {
                    $user = $user->first();
                    $currentLang = $this->getUserCurrentLanguage($user);
                    $userBs = User\BasicSetting::query()
                        ->where('language_id',$currentLang->id)
                        ->where('user_id',$user->id)
                        ->first();
                    $keywords = json_decode($currentLang->keywords, true);    
                    return response()->view('errors.user-404', ['userBs' => $userBs, 'keywords'=> $keywords], 404);
                } else {
                    return response()->view('errors.404', [], 404);
                }
            }

            // custom domain & subdomain based user URL
            elseif ($request->getHost() != env('WEBSITE_HOST')) {

                // if it's a subdomain
                if(str_contains($request->getHost(), env('WEBSITE_HOST'))){
                    // if subdomain based URL, get username & fetch user & user_basic_settings
                    $host = $request->getHost();
                    $host = str_replace("www.","",$host);
                    $hostArr = explode('.', $host);
                    $username = $hostArr[0];
                    $user = User::query()->where('username', $username);
                    if ($user->count() > 0) {
                        $currentLang = $this->getUserCurrentLanguage($user);
                        $userBs = User\BasicSetting::query()
                            ->where('language_id',$currentLang->id)
                            ->where('user_id',$user->id)
                            ->first();
                        $keywords = json_decode($currentLang->keywords, true);    
                        return response()->view('errors.user-404', ['userBs' => $userBs, 'keywords'=> $keywords], 404);
                    }
                } else {
                    $host = $request->getHost();
                    // Always include 'www.' at the begining of host
                    if (!str_starts_with($host, 'www.')) {
                        $host = 'www.' . $host;
                    }

                    $user = User::query()->whereHas('custom_domains', function($q) use ($host) {
                        $q->where('status','=',1)
                            ->where(function ($query) use ($host) {
                                $query->where('requested_domain','=',$host)
                                    ->orWhere('requested_domain','=',str_replace("www.","",$host));
                            });
                        // fetch the custom domain , if it matches 'with www.' URL or 'without www.' URL
                    });

                    if ($user->count() > 0) {
                        $user = $user->first();
                        $currentLang = $this->getUserCurrentLanguage($user);
                        $userBs = User\BasicSetting::query()
                            ->where('language_id',$currentLang->id)
                            ->where('user_id',$user->id)
                            ->first();
                        $keywords = json_decode($currentLang->keywords, true);        
                        return response()->view('errors.user-404', ['userBs' => $userBs, 'keywords'=> $keywords], 404);
                    } else {
                        return response()->view('errors.404', [], 404);
                    }
                }

            }
            // main website 404 page
            else {
                return response()->view('errors.404', [], 404);
            }
        }
        return parent::render($request, $exception);
    }
}
