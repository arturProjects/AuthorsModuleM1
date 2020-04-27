<?php


class Company_Authors_Model_Authors extends Mage_Core_Model_Abstract
{
    const Company_AUTHOR_ATTRIBUTE_ID = 135;
    
    /**
     * _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Company_authors/authors');
    }

    /**
     * @Companyram $schedule
     */
   public function massMakeTableForAuthors($schedule)
   {
       $resource = Mage::getSingleton('core/resource');
       $readConnection = $resource->getConnection('core_read');
       $tableName = $resource->getTableName('catalog_product_entity_text');
       $query = 'SELECT attribute_id, entity_id, value FROM ' . $tableName . ' WHERE attribute_id = ' .(int)self::Company_AUTHOR_ATTRIBUTE_ID;
       $results = $readConnection->fetchAll($query);

       $authors = [];
       foreach($results as $product)
       {
           if(is_int(strpos($product['value'], ';')))
           {
               $manyAuthors = explode(';', $product['value']);
               $q = count($manyAuthors);
               for($i = 0; $i < $q; $i++)
               {
                   if(array_key_exists($manyAuthors[$i], $authors))
                   {
                       array_push($authors[$manyAuthors[$i]], $product['entity_id']);
                   }
                   else
                   {
                       $authors[$manyAuthors[$i]] = [];
                       array_push($authors[$manyAuthors[$i]], $product['entity_id']);
                   }
               }
           }
          else
           {
               if(array_key_exists($product['value'], $authors))
               {
                   array_push($authors[$product['value']], $product['entity_id']);
               }
               else
               {
                   $authors[$product['value']] = [];
                   array_push($authors[$product['value']], $product['entity_id']);
               }
           }
       }

       foreach($authors as $key => $value)
       { 
            if(empty($key))
            {
               continue;
            }   
            $is_author_name_ok = 1;
            $diacritics = 'aàȁáâǎãāăȃȧäåẚảạḁąᶏậặầằắấǻẫẵǡǟẩẳⱥæǽǣᴂꬱꜳꜵꜷꜹꜻꜽɐɑꭤᶐꬰɒͣᵃªᵄᵆᵅᶛᴬᴭᴀᴁₐbḃƅƀᵬɓƃḅḇᶀꞗȸßẞꞵꞛꞝᵇᵝᴮᴯʙᴃᵦcćĉčċƈçḉɕꞔꞓȼ¢ʗᴐᴒɔꜿᶗꝢꝣ©ͨᶜᶝᵓᴄdďḋᵭðđɗᶑḓḍḏḑᶁɖȡꝱǳʣǆʤʥȸǲǅꝺẟƍƌͩᵈᶞᵟᴰᴅᴆeèȅéēêěȇĕẽėëẻḙḛẹȩęᶒⱸệḝềḕếḗễểɇəǝɘɚᶕꬲꬳꬴᴔꭁꭂ•ꜫɛᶓȝꜣꝫɜᴈᶔɝɞƩͤᵉᵊᵋᵌᶟᴱᴲᴇⱻₑₔfẜẝƒꬵḟẛᶂᵮꞙꝭꝼʩꟻﬀﬁﬂﬃﬄᶠꜰgǵḡĝǧğġģǥꬶᵷɡᶃɠꞡᵍᶢᴳɢʛhħĥȟḣḧɦɧḫḥẖḩⱨꜧꞕƕɥʮʯͪʰʱꭜᶣᵸꟸᴴʜₕiìȉíīĩîǐȋĭïỉɨḭịįᶖḯıɩɪꭠꭡᴉᵻᵼĳỻİꟾꟷͥⁱᶤᶦᵎᶧᶥᴵᵢjȷĵǰɉɟʝĳʲᶡᶨᴶᴊⱼkḱǩꝁꝃꝅƙḳḵⱪķᶄꞣʞĸᵏᴷᴋₖlĺľŀłꝉƚⱡɫꬷꬸɬꬹḽḷḻļɭȴᶅꝲḹꞎꝇꞁỻǈǉʪʫɮˡᶩᶪꭝꭞᶫᴸʟᴌₗmḿṁᵯṃɱᶆꝳꬺꭑᴟɯɰꟺꟿꟽͫᵐᶬᶭᴹᴍₘnǹńñňŉṅᵰṇṉṋņŋɳɲƞꬻꬼȵᶇꝴꞃꞑꞥᴝᴞǋǌⁿᵑᶯᶮᶰᴺᴻɴᴎₙoᴏᴑòȍóǿőōõôȏǒŏȯöỏơꝍọǫⱺꝋɵøᴓǭộợồṑờốṍṓớỗỡṏȭȱȫổởœɶƣɸƍꝏʘꬽꬾꬿꭀꭁꭂꭃꭄꭢꭣ∅ͦᵒᶱºꟹᶲᴼᴽₒpṕṗꝕꝓᵽᵱᶈꝑþꝥꝧƥƪƿȹꟼᵖᴾᴘᴩᵨₚqʠɋꝙꝗȹꞯʘθᶿrŕȑřȓṙɍᵲꝵꞧṛŗṟᶉꞅɼɽṝɾᵳᴦɿſⱹɹɺɻ®ꝶꭇꭈꭉꭊꭋꭌͬʳʶʴʵᴿʀʁᴙᴚꭆᵣsśŝšṡᵴꞩṣşșȿʂᶊṩṥṧƨʃʄʆᶋᶘꭍʅƪﬅﬆˢᶳᶴꜱₛtťṫẗƭⱦᵵŧꝷṱṯṭţƫʈțȶʇꞇꜩʦʧʨᵺͭᵗᶵᵀᴛₜuùȕúűūũûǔȗŭüůủưꭒʉꞹṷṵụṳųᶙɥựǜừṹǘứǚữṻǖửʊᵫᵿꭎꭏꭐꭑͧᵘᶶᶷᵙᶸꭟᵁᴜᵾᵤvṽⱱⱴꝟṿᶌʋʌͮᵛⱽᶹᶺᴠᵥwẁẃŵẇẅẘⱳẉꝡɯɰꟽꟿʍʬꞶꞷʷᵚᶭᵂᴡxẋẍᶍ×ꭓꭔꭕꭖꭗꭘꭙˣ˟ᵡₓᵪyỳýȳỹŷẏÿẙỷƴɏꭚỵỿɣɤꝩʎƛ¥ʸˠᵞʏᵧzźẑžżƶᵶẓẕʐᶎʑȥⱬɀʒǯʓƺᶚƹꝣᵹᶻᶼᶽᶾᴢᴣ';
            if(str_word_count($key,0,$diacritics) > 3)
            {
               $is_author_name_ok = 0;
               $data = ['origin_entity_id' => $value[0], 'name' => trim($key), 'is_author_name_ok' => $is_author_name_ok, 
                'author_url_key' => Mage::helper('Company_product')->encodeCustomUrlKeyForAuthor($key), 
                'author_description' => '', 'author_products' => json_encode($value)];
            }
            else 
            {
                $data = ['origin_entity_id' => 0, 'name' => trim($key), 'is_author_name_ok' => $is_author_name_ok, 
                'author_url_key' => Mage::helper('Company_product')->encodeCustomUrlKeyForAuthor($key), 
                'author_description' => '', 'author_products' => json_encode($value)];
            }
            
            $author = Mage::getModel('Company_authors/authors')->setData($data);
            $author->save();
       }
    }
}
