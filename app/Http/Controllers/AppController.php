<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class AppController extends Controller
{
    /*const TD_WIDTH = 135*2;
    const TD_HEIGHT = 75*2;
    const TD_MARGIN = 4*2;*/

    const WEB_LG_WIDTH = 379;
    const WEB_LG_HEIGHT = 382;
    const WEB_SM_WIDTH = 122;
    const WEB_SM_HEIGHT = 126;
    const WEB_MARGIN = 1;

    const MOB_WIDTH = 418;
    const MOB_HEIGHT = 232;
    const MOB_MARGIN = 12;

    /**
     * Show the profile for the given user.
     *
     * @param Request $request
     * @return Response
     */
    public function split(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'pic' => 'required|mimes:jpeg,png|max:5000',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $orig_pic = Image::make($request->pic);

        /*// Tweetdeck
        $tweetdeck_fit = (clone $orig_pic)->fit(self::TD_WIDTH*2 + self::TD_MARGIN,
                                                self::TD_HEIGHT*2 + self::TD_MARGIN);

        $pics['tweetdeck'][] = (clone $tweetdeck_fit)
            ->crop(self::TD_WIDTH, self::TD_HEIGHT, 0, 0);
        $pics['tweetdeck'][] = (clone $tweetdeck_fit)
            ->crop(self::TD_WIDTH, self::TD_HEIGHT, self::TD_WIDTH + self::TD_MARGIN, 0);
        $pics['tweetdeck'][] = (clone $tweetdeck_fit)
            ->crop(self::TD_WIDTH, self::TD_HEIGHT, 0, self::TD_HEIGHT + self::TD_MARGIN);
        $pics['tweetdeck'][] = (clone $tweetdeck_fit)
            ->crop(self::TD_WIDTH, self::TD_HEIGHT, self::TD_WIDTH + self::TD_MARGIN, self::TD_HEIGHT + self::TD_MARGIN);*/

        // Mobile
        $mobile_fit = (clone $orig_pic)->fit(self::MOB_WIDTH*2 + self::MOB_MARGIN,
            self::MOB_HEIGHT*2 + self::MOB_MARGIN);

        $pics['mobile'][] = (clone $mobile_fit)
            ->crop(self::MOB_WIDTH, self::MOB_HEIGHT, 0, 0);
        $pics['mobile'][] = (clone $mobile_fit)
            ->crop(self::MOB_WIDTH, self::MOB_HEIGHT, self::MOB_WIDTH + self::MOB_MARGIN, 0);
        $pics['mobile'][] = (clone $mobile_fit)
            ->crop(self::MOB_WIDTH, self::MOB_HEIGHT, 0, self::MOB_HEIGHT + self::MOB_MARGIN);
        $pics['mobile'][] = (clone $mobile_fit)
            ->crop(self::MOB_WIDTH, self::MOB_HEIGHT, self::MOB_WIDTH + self::MOB_MARGIN, self::MOB_HEIGHT + self::MOB_MARGIN);


        // Desktop
        $desktop_fit = (clone $orig_pic)->fit(self::WEB_LG_WIDTH + self::WEB_MARGIN + self::WEB_SM_WIDTH,
                                                self::WEB_LG_HEIGHT);

        $pics['desktop'][] = (clone $desktop_fit)
            ->crop(self::WEB_LG_WIDTH, self::WEB_LG_HEIGHT, 0, 0);
        $pics['desktop'][] = (clone $desktop_fit)
            ->crop(self::WEB_SM_WIDTH, self::WEB_SM_HEIGHT, self::WEB_LG_WIDTH + self::WEB_MARGIN, 0);
        $pics['desktop'][] = (clone $desktop_fit)
            ->crop(self::WEB_SM_WIDTH, self::WEB_SM_HEIGHT, self::WEB_LG_WIDTH + self::WEB_MARGIN, self::WEB_SM_HEIGHT + self::WEB_MARGIN);
        $pics['desktop'][] = (clone $desktop_fit)
            ->crop(self::WEB_SM_WIDTH, self::WEB_SM_HEIGHT, self::WEB_LG_WIDTH + self::WEB_MARGIN, (self::WEB_SM_HEIGHT + self::WEB_MARGIN)*2);



        $rand = rand(1000000,9999999);

        $i = 0;
        foreach(array_keys($pics) as $format){
            foreach($pics[$format] as $pic){
                $pic->save(public_path() . '/uploads/' . $rand . '-' . $i . '.jpg');
                $i++;
            }
        }

        return view('pics', compact('rand'));
    }
}