<?php

use Illuminate\Database\Seeder;
use App\SidebarHTMLs;

class SidebarHTMLsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SidebarHTMLs::create([
            'title'=>'faltu',
            'content'=>'<div class="p-4 mb-3 bg-light rounded"><h4 class="font-italic">About</h4> <p class="mb-0">Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p></div>'
        ]);

        SidebarHTMLs::create([
            'title'=>'faltu',
            'content'=>'<ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                            Cras justo odio
                                <span class="badge badge-primary badge-pill">14</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                            Dapibus ac facilisis in
                                <span class="badge badge-primary badge-pill">2</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                            Morbi leo risus
                                <span class="badge badge-primary badge-pill">1</span>
                            </li>
                        </ul>'
        ]);

        SidebarHTMLs::create([
            'title'=>'faltu',
            'content'=>'<div class="p-4">
                    <h4 class="font-italic">Archives</h4>
                    <ol class="list-unstyled mb-0">
                        <li><a href="#">March 2014</a></li>
                        <li><a href="#">February 2014</a></li>
                        <li><a href="#">January 2014</a></li>
                        <li><a href="#">December 2013</a></li>
                        <li><a href="#">November 2013</a></li>
                        <li><a href="#">October 2013</a></li>
                        <li><a href="#">September 2013</a></li>
                        <li><a href="#">August 2013</a></li>
                        <li><a href="#">July 2013</a></li>
                        <li><a href="#">June 2013</a></li>
                        <li><a href="#">May 2013</a></li>
                        <li><a href="#">April 2013</a></li>
                    </ol>
                </div>'
        ]);



        SidebarHTMLs::create([
            'title'=>'faltu',
            'content'=>'<div class="p-4">
                    <h4 class="font-italic">Elsewhere</h4>
                    <ol class="list-unstyled">
                        <li><a href="#">GitHub</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Facebook</a></li>
                    </ol>
                </div>'
        ]);
    }
}
