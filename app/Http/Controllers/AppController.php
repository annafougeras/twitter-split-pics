<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class AppController extends Controller
{
    const WEB_LG_WIDTH = 379;
    const WEB_LG_HEIGHT = 380;
    const WEB_SM_WIDTH = 122;
    const WEB_SM_HEIGHT = 126;
    const WEB_MARGIN = 1;

    const MOB_WIDTH = 418;
    const MOB_HEIGHT = 232;
    const MOB_MARGIN = 12;

    /**
     * Split the given picture into 4 mobile Twitter thumbnails and 4 desktop Twitter thumbnails,
     * and store the thumbnails in the uploads folder
     *
     * @param Request $request
     * @return Response
     */
    public function split(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'picture' => 'required|mimes:jpeg,png|max:2000',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $orig_pic = Image::make($request->picture);

        // Mobile thumbnails creation
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


        // Desktop thumbnails creation
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


        // Store the created pictures
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