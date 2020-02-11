<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Company;

class WebScraperController extends Controller
{
    public function index()
    {
        // include("simple_html_dom.php");



        for ($iii = 0; $iii < 50; $iii++) {
            $html = file_get_html('https://www.medpages.info/sf/index.php?page=newsearchresults&q=Veterinary%20surgeons&sp=no&lat=&long=1&pageno=' . $iii);

            $address_temp = [];
            $address = [];
            $phone = [];
            $ar = [];
            $list_check = [];
            $company = [];
            //   $data_table = [];

            $phone = [];
            $description = [];
            $data_table2 = [];
            $location = [];

            //$list=$html->find('section[class="result-record"]',$x);
            $list_array = $html->find('a');

            for ($i = 0; $i < count($list_array); $i++) {
                $list_check[] = $list_array[$i]->href;
            }

            for ($com = 0; $com < 10; $com++) {
                $company[] = $html->find('h2', $com)->plaintext;
            }
            for ($loc = 0; $loc < 10; $loc++) {
                $loc_ar = $html->find('div[class="result-details"]', $loc);
                for ($ziw = 0; $ziw < 1; $ziw++) {
                    if (!empty($loc_ar)) {
                        if ($loc_ar) {
                            $location[] = $loc_ar->find('h4', $ziw)->plaintext;
                        }
                    }
                }
            }


            // for ($g = 0; $g < count($company); $g++) {
            //     echo $company[$g];
            //     echo "<br/>";
            //     echo "<br/>";
            //     echo "<br/>";
            // }
            // return "stop";

            //$num=substr($data1, -1)
            for ($i = 0; $i < count($list_check); $i++) {

                $check = substr($list_check[$i], -3);


                if (is_numeric($check)) {
                    if (strlen($list_check[$i]) > 18) {
                        $ar[] = $list_check[$i];
                    }
                }
            }

            //getting all contacts in the table as html, assign html table to a value
            for ($s = 0; $s < count($ar); $s++) {
                $html2 = file_get_html('https://www.medpages.info/sf/' . $ar[$s]);

                for ($e = 0; $e < 10; $e++) {
                    $link_ar = $html2->find('section[class="contact-info bottom-border"]', $e);


                    for ($sy = 0; $sy < 10; $sy++) {

                        //work on this shit tommorrow
                        if ($link_ar) {
                            $data_table = $link_ar->find('table[class="info-table"]', $sy);
                            //Stop

                            for ($zi = 0; $zi < 1; $zi++) {
                                if ($data_table) {
                                    $phone[] = $data_table->find('td[class="col-lg-10 text-left"]', $zi)->plaintext;
                                }
                            }

                            // $data_table2 = $link_ar->find('table[class="info-table"]', $sy);
                            // for ($fi = 0; $fi < 2; $fi++) {
                            //     if ($data_table2) {
                            //         $address[] = $data_table2->find('td[class="col-lg-10 text-left"]', $fi)->plaintext;
                            //     }
                            // }
                        }
                    }
                }


                // for ($kkk = 0; $kkk < count($address); $kkk++) {
                //     if (strlen($address[$kkk]) > 15) {
                //         $address_temp[] = $address[$kkk];
                //     } else {
                //         $address_temp[] = "NULL";
                //     }
                // }
                $data = new Company;
                for ($ib = 0; $ib < 10; $ib++) {
                    if (!empty($company[$ib]) && !empty($phone[$ib])) {
                        $data->catergory_id = 116;
                        $data->name = $company[$ib];
                        $data->location = $location[$ib];
                        //$data->address = $address_temp[$ib];
                        $data->telephone = $phone[$ib];
                        //  $data->description = $description[$i];
                        $data->save();
                    }
                }
            }
            // for ($ui = 0; $ui < count($data_table2); $ui++) {
            //     for ($li = 0; $li < 2000; $li++) {
            //         if ($data_table2[$ui]) {

            //             $address_temp = $data_table2->find('td[class="col-lg-10 text-left"]', $li);
            //         }
            //     }
            //     $address[] = $address_temp->plaintext;
            // }







            // for ($zz = 0; $zz < count($address_temp); $zz++) {
            //     echo $address_temp[$zz];
            // }



            // for ($zi = 0; $zi < 1; $zi++) {
            //     if ($data_table) {
            //         $phone[] = $data_table->find('td[class="col-lg-10 text-left"]', $zi);
            //     }
            // }


            // $description[] = $zink_descr[$zi]->find('td[class="col-lg-10 text-left"]', $gi)->plaintext;



            // for ($fi = 0; $fi < 10; $fi++) {
            //     $data1 = $data_table[$zi]->find('td[class="col-lg-10 text-left"]', $fi);
            //     if (strlen($data1) > 15) {
            //         $address[] = $data1;
            //     }
            // }




        }
    }
}