<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;

class FileController extends Controller
{
    public function store(Request $request)
    {
        if (request()->file('scheme_image')) {
            $file = request()->file('scheme_image');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/schemes')) {
                mkdir(public_path() . '/uploads/schemes', 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(3840, 2160, function ($const) {
                $const->aspectRatio();
            })->save(public_path() . '/uploads/schemes/' . $filename);

            return \Response::make('/uploads/schemes/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('banner_image')) {
            $file = request()->file('banner_image');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/banners')) {
                mkdir(public_path() . '/uploads/banners', 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(2000, 2000, function ($const) {
                $const->aspectRatio();
            })->save(public_path() . '/uploads/banners/' . $filename);

            return \Response::make('/uploads/banners/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('banner_video')) {
            $file = request()->file('banner_video');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/banners')) {
                mkdir(public_path() . '/uploads/banners', 0755, true);
            }

            $file->move(public_path() . '/uploads/banners', $filename);

            return \Response::make('/uploads/banners/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('screensaver_image')) {
            $file = request()->file('screensaver_image');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/screensavers')) {
                mkdir(public_path() . '/uploads/screensavers', 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(2000, 2000, function ($const) {
                $const->aspectRatio();
            })->save(public_path() . '/uploads/screensavers/' . $filename);

            return \Response::make('/uploads/screensavers/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('screensaver_video')) {
            $file = request()->file('screensaver_video');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/screensavers')) {
                mkdir(public_path() . '/uploads/screensavers', 0755, true);
            }

            $file->move(public_path() . '/uploads/screensavers', $filename);

            return \Response::make('/uploads/screensavers/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('block_image')) {
            $file = request()->file('block_image');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/page_block_images')) {
                mkdir(public_path() . '/uploads/page_block_images', 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(2000, 2000, function ($const) {
                $const->aspectRatio();
            })->save(public_path() . '/uploads/page_block_images/' . $filename);

            return \Response::make('/uploads/page_block_images/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('block_images')) {
            $files = request()->file('block_images');

            for ($i = 0; $i < count($files); $i++) {
                $file = $files[$i];
                $filename = time().'.'.$file->extension();

                if (!file_exists(public_path() . '/uploads/page_block_images')) {
                    mkdir(public_path() . '/uploads/page_block_images', 0755, true);
                }

                $img = Image::make($file->path());
                $img->resize(2000, 2000, function ($const) {
                    $const->aspectRatio();
                })->save(public_path() . '/uploads/page_block_images/' . $filename);

                return \Response::make('/uploads/page_block_images/' . $filename, 200, [
                    'Content-Disposition' => 'inline',
                ]);
            }
        }

        if (request()->file('block_video')) {
            $file = request()->file('block_video');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/page_block_videos')) {
                mkdir(public_path() . '/uploads/page_block_videos', 0755, true);
            }

            $file->move(public_path() . '/uploads/page_block_videos', $filename);

            return \Response::make('/uploads/page_block_videos/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('block_audio')) {
            $file = request()->file('block_audio');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/page_block_audios')) {
                mkdir(public_path() . '/uploads/page_block_audios', 0755, true);
            }

            $file->move(public_path() . '/uploads/page_block_audios', $filename);

            return \Response::make('/uploads/page_block_audios/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('block_pdf')) {
            $file = request()->file('block_pdf');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/page_block_pdfs')) {
                mkdir(public_path() . '/uploads/page_block_pdfs', 0755, true);
            }

            $file->move(public_path() . '/uploads/page_block_pdfs', $filename);

            return \Response::make('/uploads/page_block_pdfs/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('block_excel')) {
            $file = request()->file('block_excel');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/page_block_excels')) {
                mkdir(public_path() . '/uploads/page_block_excels', 0755, true);
            }

            $file->move(public_path() . '/uploads/page_block_excels', $filename);

            return \Response::make('/uploads/page_block_excels/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('icon_image')) {
            $file = request()->file('icon_image');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/icons')) {
                mkdir(public_path() . '/uploads/icons', 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(1000, 1000, function ($const) {
                $const->aspectRatio();
            })->save(public_path() . '/uploads/icons/' . $filename);

            return \Response::make('/uploads/icons/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('event_image')) {
            $file = request()->file('event_image');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/events')) {
                mkdir(public_path() . '/uploads/events', 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(2000, 2000, function ($const) {
                $const->aspectRatio();
            })->save(public_path() . '/uploads/events/' . $filename);

            return \Response::make('/uploads/events/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }
    }
}
