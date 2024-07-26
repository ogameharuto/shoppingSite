<!DOCTYPE html>
<!-- saved from url=(0327)https://signup-bizmanager.yahoo.co.jp/v3/input?ppt_id=4001&key_cd=A4P1oWYAAIgstH4Ce_8icvusze8tFyaXUt0CsrwqzLYvvImXgYQ3DWV8mueGJwGa80SbljsywOqpctR-7cKQ0oaOqTfHs3cjS2Mk0KJq3kEtGcPz&crumb=AoP1oWYAKMFnbnTH1gowSK0q_X-PjnKXIH3TVk8QhGTOV-uDxkuHz_Fr1CbLkj7UE6Si_88kFDCzkVkz9Ct80bVI733ZgHvhejBjPqEHP-Fje_JjZ7VNPIKhmvzie15s7wKx6jBk&sem=0 -->
<html lang="ja"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <meta http-equiv="Content-Script-Type" content="text/javascript">
  <!--/.pageTitle_l-->
</div>
          <span class="line">&nbsp;</span>
        </div>
  <form name="Form01" action="https://signup-bizmanager.yahoo.co.jp/v3/confirm?ppt_id=4001&amp;key_cd=A4P1oWYAAIgstH4Ce_8icvusze8tFyaXUt0CsrwqzLYvvImXgYQ3DWV8mueGJwGa80SbljsywOqpctR-7cKQ0oaOqTfHs3cjS2Mk0KJq3kEtGcPz&amp;sem=0" method="post" class="FromStyle" id="Form01">

      <div>
  

</div> 
        <div>

  <div id="fcom">

    
    <fieldset class="ClearFix">
      <p class="yjCategoryTitle">
        <legend>会社情報</legend>
      </p>

      <div class="yjMainArea">

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label>事業形態</label><em class="yjMastMark">必須</em></p>
          </div>
          <div class="AreaR">
            <p>
              <label><input name="input_cmp_business_kind_sub" type="radio" value="法人" id="InBusinessType1" class="yjChkValEmpty" checked="checked">法人</label>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <label><input name="input_cmp_business_kind_sub" type="radio" value="個人事業主" id="InBusinessType2" class="yjChkValEmpty">個人事業主</label>
            </p>
            
            <p class="errorField" id="InBusinessTypeError"><span style="display:block;height:0;overflow:hidden;">&nbsp;</span></p>
            
          </div>
        </div>
        


        
        <div id="yjHydeAreaBusinessType1" class="hidewrrap" style="display: block; height: auto; overflow: visible;">

          
          <div class="ctrlHolder ClearFix">
            <div class="AreaL">
              <p><label for="InCompanyType">企業形態</label><em class="yjMastMark">必須</em></p>
            </div>
            <div class="AreaR">
              <p>
                <select name="input_cmp_business_kind" id="InCompanyType" class="yjChkValEmpty">
                  <option value="" selected="selected">選択してください
                  </option>
                  <option value="株式会社">株式会社
                  </option>
                  <option value="有限会社">有限会社
                  </option>
                  <option value="合資会社">合資会社
                  </option>
                  <option value="財団法人">財団法人
                  </option>
                  <option value="社団法人">社団法人
                  </option>
                  <option value="宗教法人">宗教法人
                  </option>
                  <option value="学校法人">学校法人
                  </option>
                  <option value="合名会社">合名会社
                  </option>
                  <option value="特定非営利活動法人">特定非営利活動法人
                  </option>
                  <option value="合同会社">合同会社
                  </option>
                  <option value="協同組合">協同組合
                  </option>
                  <option value="その他法人">その他法人
                  </option>
                </select>
                <span class="okField" id="InCompanyTypeOK"></span>
              </p>
              
              <p class="errorField" id="InCompanyTypeError"></p>
              
            </div>
          </div>
          


          
          <div class="ctrlHolder ClearFix">
            <div class="AreaL">
              <p><label>企業形態の位置</label><em class="yjMastMark">必須</em></p>
            </div>
            <div class="AreaR">
              <p>
                <label><input name="input_cmp_business_kind_pos" type="radio" class="yjChkValEmpty" id="InCompanyPosition1" value="1" checked="checked">会社名の前</label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label><input name="input_cmp_business_kind_pos" type="radio" class="yjChkValEmpty" value="2" id="InCompanyPosition2">会社名の後</label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label><input name="input_cmp_business_kind_pos" type="radio" class="yjChkValEmpty" value="0" id="InCompanyPosition3" disabled="">なし</label>
              </p>
              
              <p class="errorField" id="InCompanyPositionError"><span style="display:block;height:0;overflow:hidden;">&nbsp;</span></p>
              
            </div>
          </div>
          <div class="ctrlHolder ClearFix">
            <div class="AreaL">
              <p><label for="InCompanyHoujinBangou">法人番号</label><em class="yjMastMark">条件付必須</em><br><em>（半角数字）</em></p>
            </div>
            <div class="AreaR">
              <p>
                <input name="input_cmp_houjin_bangou" type="text" id="InCompanyHoujinBangou" placeholder="例）1234567890123" class="yjChkValEmpty yjChkValNumber yjChkValRange-13-13" value=""><span class="okField" id="InCompanyHoujinBangouOK"></span>
              </p>
            </div>
          </div>
        </div>
        <div id="yjHydeAreaBusinessType2" class="hidewrrap" style="height: 1px; display: none;">
          
          <div class="ctrlHolder ClearFix">
            <div class="AreaR">
              <p class="miniTxt">個人事業主様は、屋号（もしくは事業主名）を入力してください。</p>
            </div>
          </div>
          
        </div>
        


        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="InCompanyName">会社名</label><em class="yjMastMark">必須</em><br><em>（全角）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="input_cmp_name" type="text" id="InCompanyName" placeholder="例）矢風商事" class="yjChkValEmpty imeOn" maxlength="60" value="">
              <span class="okField" id="InCompanyNameOK"></span>
            </p>
            
            <p class="errorField" id="InCompanyNameError"><span class="yjAlertView">「会社名」を入力してください。</span></p>
            
            <p class="errorField" id="InCompanyNameInfo"><span style="display:block;line-height:0;">&nbsp;</span></p>
          </div>
          <div id="yjJsPreview" class="yjPreviewInputBox ClearFix" style="display: none;">
            <div class="yjPreviewInputArrow">&nbsp;</div>
            <div class="ctrlHolder">
              <div class="AreaL">
                <p><span id="yjCompanyNameLabel">&nbsp;</span><label>会社名</label></p>
              </div>
              <div class="AreaR">
                <p class="yjWordBreak"><span id="BisKind1">&nbsp;</span><strong id="yjCompanyNamePreview"></strong><span id="BisKind2"></span>&nbsp;様</p>
              </div>
            </div>
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="InCompanyKana">会社名フリガナ</label><em class="yjMastMark">必須</em><br><em>（全角カタカナ）<br>
              ※数字や記号、半角カタカナは使用できません</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="input_cmp_name_kana" type="text" id="InCompanyKana" placeholder="例）ヤフウショウジ" class="yjChkValEmpty yjChkValFullKana imeOn" maxlength="60" value="">
              <span class="okField" id="InCompanyKanaOK"></span>
            </p>
            
            <p class="errorField" id="InCompanyKanaError"></p>
        
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="InCompanyPostNum">郵便番号</label><em class="yjMastMark">必須</em><br><em>（半角数字）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="input_cmp_zip" type="text" id="InCompanyPostNum" placeholder="例）102-8282" class="yjChkValEmpty yjChkValNumHyp yjChkValZipHyphen imeOff" value="">
              <input name="input_cmp_zip1" type="hidden" id="InCompanyPostNum1" value="">
              <input name="input_cmp_zip2" type="hidden" id="InCompanyPostNum2" value="">
              <span class="okField" id="InCompanyPostNumOK"></span>
              <span class="okField" id="InCompanyPostNumSending"></span>
            </p>
            
            <p class="errorField" id="InCompanyPostNumError"></p>
            
            
            <p class="errorField" id="InCompanyPostNumAjaxError"></p>
            
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="InCompanyPref">都道府県</label><em class="yjMastMark">必須</em></p>
          </div>
          <div class="AreaR">
            <p>
              <select name="input_cmp_pref" id="InCompanyPref" class="yjChkValEmpty">
                <option value="" selected="selected">選択してください</option>
                <optgroup label="北海道">
                  <option value="北海道">北海道</option>
                </optgroup><optgroup label="東北">
                  <option value="青森県">青森県</option>
                  <option value="秋田県">秋田県</option>
                  <option value="岩手県">岩手県</option>
                  <option value="山形県">山形県</option>
                  <option value="宮城県">宮城県</option>
                  <option value="福島県">福島県</option>
                </optgroup><optgroup label="関東">
                  <option value="栃木県">栃木県</option>
                  <option value="群馬県">群馬県</option>
                  <option value="茨城県">茨城県</option>
                  <option value="埼玉県">埼玉県</option>
                  <option value="千葉県">千葉県</option>
                  <option value="東京都">東京都</option>
                  <option value="神奈川県">神奈川県</option>
                  <option value="山梨県">山梨県</option>
                </optgroup><optgroup label="甲信越">
                  <option value="長野県">長野県</option>
                  <option value="新潟県">新潟県</option>
                </optgroup><optgroup label="北陸">
                  <option value="富山県">富山県</option>
                  <option value="石川県">石川県</option>
                  <option value="福井県">福井県</option>
                </optgroup><optgroup label="東海">
                  <option value="静岡県">静岡県</option>
                  <option value="岐阜県">岐阜県</option>
                  <option value="愛知県">愛知県</option>
                  <option value="三重県">三重県</option>
                </optgroup><optgroup label="近畿">
                  <option value="和歌山県">和歌山県</option>
                  <option value="奈良県">奈良県</option>
                  <option value="滋賀県">滋賀県</option>
                  <option value="京都府">京都府</option>
                  <option value="大阪府">大阪府</option>
                  <option value="兵庫県">兵庫県</option>
                </optgroup><optgroup label="中国">
                  <option value="鳥取県">鳥取県</option>
                  <option value="岡山県">岡山県</option>
                  <option value="島根県">島根県</option>
                  <option value="広島県">広島県</option>
                  <option value="山口県">山口県</option>
                </optgroup><optgroup label="四国">
                  <option value="徳島県">徳島県</option>
                  <option value="香川県">香川県</option>
                  <option value="愛媛県">愛媛県</option>
                  <option value="高知県">高知県</option>
                </optgroup><optgroup label="九州">
                  <option value="福岡県">福岡県</option>
                  <option value="佐賀県">佐賀県</option>
                  <option value="長崎県">長崎県</option>
                  <option value="熊本県">熊本県</option>
                  <option value="大分県">大分県</option>
                  <option value="宮崎県">宮崎県</option>
                  <option value="鹿児島県">鹿児島県</option>
                </optgroup><optgroup label="沖縄">
                  <option value="沖縄県">沖縄県</option>
                </optgroup>
              </select>
              <span class="okField" id="InCompanyPrefOK"></span>
            </p>
            
            <p class="errorField" id="InCompanyPrefError"></p>
            
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="InCompanyAddress1">市区町村</label><em class="yjMastMark">必須</em><br><em>（全角）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="input_cmp_address1" type="text" id="InCompanyAddress1" placeholder="例）千代田区" class="yjChkValEmpty imeOn" maxlength="45" value="">
              <span class="okField" id="InCompanyAddress1OK"></span>
            </p>
            
            <p class="errorField" id="InCompanyAddress1Error"></p>
            
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="InCompanyAddress2">町・字名</label><em class="yjMastMark">必須</em><br><em>（全角）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="input_cmp_address2" type="text" id="InCompanyAddress2" placeholder="例）紀尾井町" class="yjChkValEmpty imeOn" maxlength="45" value="">
              <span class="okField" id="InCompanyAddress2OK"></span>
            </p>
            
            <p class="errorField" id="InCompanyAddress2Error"></p>
            
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="InCompanyAddress3"> 丁目・番地・号</label><em class="yjMastMark">必須</em><br><em>（全角）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="input_cmp_address3" type="text" id="InCompanyAddress3" placeholder="例）1-3" class="yjChkValEmpty imeOn" maxlength="40" value="">
              <span class="okField" id="InCompanyAddress3OK"></span>
            </p>
            
            <p class="errorField" id="InCompanyAddress3Error"></p>
            
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="InCompanyAddress4">ビル名</label><em class="yjOptionMark">任意</em><br><em>（全角）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="input_cmp_build" type="text" id="InCompanyAddress4" placeholder="例）紀尾井町タワー" class="imeOn" maxlength="40" value="">
            </p>
            
            <p class="errorField" id="InCompanyAddress4Error"></p>
            
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="original_paramCompanyPrefKana">都道府県フリガナ</label><em class="yjMastMark">必須</em><br><em>（全角カタカナ）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="original[company_pref_kana]" type="text" id="original_paramCompanyPrefKana" placeholder="例）トウキョウト" class="yjChkValEmpty yjChkValFullKanaSHP imeOn" maxlength="6" value="">
              <span class="okField" id="original_paramCompanyPrefKanaOK"></span>
            </p>
            
            <p class="errorField" id="original_paramCompanyPrefKanaError"></p>
            
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="original_paramCompanyAddress1Kana">市区町村フリガナ</label><em class="yjMastMark">必須</em><br><em>（全角カタカナ）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="original[company_address1_kana]" type="text" id="original_paramCompanyAddress1Kana" placeholder="例）チヨダク" class="yjChkValEmpty yjChkValFullKanaSHPAddress imeOn" maxlength="45" value="">
              <span class="okField" id="original_paramCompanyAddress1KanaOK"></span>
            </p>
            
            <p class="errorField" id="original_paramCompanyAddress1KanaError"></p>
            
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="original_paramCompanyAddress2Kana">町・字名フリガナ</label><em class="yjMastMark">必須</em><br><em>（全角カタカナ）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="original[company_address2_kana]" type="text" id="original_paramCompanyAddress2Kana" placeholder="例）キオイチョウ" class="yjChkValEmpty yjChkValFullKanaSHPAddress imeOn" maxlength="45" value="">
              <span class="okField" id="original_paramCompanyAddress2KanaOK"></span>
            </p>
            
            <p class="errorField" id="original_paramCompanyAddress2KanaError"></p>
            
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="original_paramCompanyAddress3Kana">丁目・番地・号フリガナ</label><em class="yjMastMark">必須</em><br><em>（全角カタカナ）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="original[company_address3_kana]" type="text" id="original_paramCompanyAddress3Kana" placeholder="例）１ー３" class="yjChkValEmpty yjChkValFullKanaSHPAddress imeOn" maxlength="40" value="">
              <span class="okField" id="original_paramCompanyAddress3KanaOK"></span>
            </p>
            
            <p class="errorField" id="original_paramCompanyAddress3KanaError"></p>
            
          </div>
        </div>
        

        
        <div class="ctrlH_kanaolder ClearFix">
          <div class="AreaL">
            <p><label for="original_paramCompanyBuildKana">ビル名フリガナ</label><em class="yjOptionMark">任意</em><br><em>（全角カタカナ）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="original[company_address4_kana]" type="text" id="original_paramCompanyBuildKana" placeholder="例）キオイチョウタワー" class="yjChkValFullKanaSHPAddress imeOn" maxlength="40" value="">
            </p>
            
            <p class="errorField" id="original_paramCompanyBuildKanaError"><span style="display:block;height:0;overflow:hidden;">&nbsp;</span></p>
            
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="InCompanyTel1">電話番号</label><em class="yjMastMark">必須</em><br><em>（半角数字）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="input_cmp_tel1" type="text" id="InCompanyTel1" placeholder="例）03" class="yjChkValNumber yjChkValEmpty yjChkValRange-0-5 imeOff" value=""> -
              <input name="input_cmp_tel2" type="text" id="InCompanyTel2" placeholder="例）1234" class="yjChkValNumber yjChkValEmpty yjChkValRange-0-5 imeOff" value=""> -
              <input name="input_cmp_tel3" type="text" id="InCompanyTel3" placeholder="例）5678" class="yjChkValNumber yjChkValEmpty yjChkValRange-0-5 imeOff" value="">
              <input name="input_cmp_tel_all" type="hidden" id="InCompanyTelAll" class="yjChkValRange-10-11 imeOff" value="1234567890">
              <span class="okField" id="InCompanyTelOK"></span>
            </p>
            
            <p class="errorField" id="InCompanyTelError"></p>
          </div>
        </div>
        
        

        
        <div id="yjHydeAreaRegistrationNo" class="hidewrrap" style="height: 1px; display: none;">

          
          <div class="yjSubInputBox ClearFix">
            
            <div class="yjSubInputBoxArrow">&nbsp;</div>
            

            
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="InRegistrationNo">登録番号（インボイス制度）</label><em class="yjMastMark">必須</em><br><em>（半角数字）</em></p>
              </div>
              <div class="AreaR">
                <p>
                <noscript>例）1234567890123<br></noscript>
                <b>T </b><input name="input_registration_no" type="text" id="InRegistrationNo" placeholder="例）1234567890123" class="yjChkValNumber yjChkValEmpty yjChkValRange-13-13 imeOff" maxlength="13" value=""><span class="okField" id="InRegistrationNoOK"></span>
                </p>
                
                <p class="errorField" id="InRegistrationNoError"></p>
              </div>
            </div>
            

          </div>
        </div>
        <div id="yjHydeAreaBusinessType3" class="hidewrrap" style="display: block; height: auto; overflow: visible;">

          
          <div class="ctrlHolder ClearFix">
            <div class="AreaL">
              <p><label for="original_paramCompanyEstablishYear">設立年月</label><em class="yjMastMark">必須</em></p>
            </div>
            <div class="AreaR">
              <p>
                <select name="original[company_foundation_year]" id="original_paramCompanyEstablishYear" class="yjChkValEmpty">
                  <option value="">年</option>
                  
                  <option value="2024">2024</option>
                  
                  <option value="2023">2023</option>
                  
                  <option value="2022">2022</option>
                  
                  <option value="2021">2021</option>
                  
                  <option value="2020">2020</option>
                  
                  <option value="2019">2019</option>
                  
                  <option value="2018">2018</option>
                  
                  <option value="2017">2017</option>
                  
                  <option value="2016">2016</option>
                  
                  <option value="2015">2015</option>
                  
                  <option value="2014">2014</option>
                  
                  <option value="2013">2013</option>
                  
                  <option value="2012">2012</option>
                  
                  <option value="2011">2011</option>
                  
                  <option value="2010">2010</option>
                  
                  <option value="2009">2009</option>
                  
                  <option value="2008">2008</option>
                  
                  <option value="2007">2007</option>
                  
                  <option value="2006">2006</option>
                  
                  <option value="2005">2005</option>
                  
                  <option value="2004">2004</option>
                  
                  <option value="2003">2003</option>
                  
                  <option value="2002">2002</option>
                  
                  <option value="2001">2001</option>
                  
                  <option value="2000">2000</option>
                  
                  <option value="1999">1999</option>
                  
                  <option value="1998">1998</option>
                  
                  <option value="1997">1997</option>
                  
                  <option value="1996">1996</option>
                  
                  <option value="1995">1995</option>
                  
                  <option value="1994">1994</option>
                  
                  <option value="1993">1993</option>
                  
                  <option value="1992">1992</option>
                  
                  <option value="1991">1991</option>
                  
                  <option value="1990">1990</option>
                  
                  <option value="1989">1989</option>
                  
                  <option value="1988">1988</option>
                  
                  <option value="1987">1987</option>
                  
                  <option value="1986">1986</option>
                  
                  <option value="1985">1985</option>
                  
                  <option value="1984">1984</option>
                  
                  <option value="1983">1983</option>
                  
                  <option value="1982">1982</option>
                  
                  <option value="1981">1981</option>
                  
                  <option value="1980">1980</option>
                  
                  <option value="1979">1979</option>
                  
                  <option value="1978">1978</option>
                  
                  <option value="1977">1977</option>
                  
                  <option value="1976">1976</option>
                  
                  <option value="1975">1975</option>
                  
                  <option value="1974">1974</option>
                  
                  <option value="1973">1973</option>
                  
                  <option value="1972">1972</option>
                  
                  <option value="1971">1971</option>
                  
                  <option value="1970">1970</option>
                  
                  <option value="1969">1969</option>
                  
                  <option value="1968">1968</option>
                  
                  <option value="1967">1967</option>
                  
                  <option value="1966">1966</option>
                  
                  <option value="1965">1965</option>
                  
                  <option value="1964">1964</option>
                  
                  <option value="1963">1963</option>
                  
                  <option value="1962">1962</option>
                  
                  <option value="1961">1961</option>
                  
                  <option value="1960">1960</option>
                  
                  <option value="1959">1959</option>
                  
                  <option value="1958">1958</option>
                  
                  <option value="1957">1957</option>
                  
                  <option value="1956">1956</option>
                  
                  <option value="1955">1955</option>
                  
                  <option value="1954">1954</option>
                  
                  <option value="1953">1953</option>
                  
                  <option value="1952">1952</option>
                  
                  <option value="1951">1951</option>
                  
                  <option value="1950">1950</option>
                  
                  <option value="1949">1949</option>
                  
                  <option value="1948">1948</option>
                  
                  <option value="1947">1947</option>
                  
                  <option value="1946">1946</option>
                  
                  <option value="1945">1945</option>
                  
                  <option value="1944">1944</option>
                  
                  <option value="1943">1943</option>
                  
                  <option value="1942">1942</option>
                  
                  <option value="1941">1941</option>
                  
                  <option value="1940">1940</option>
                  
                  <option value="1939">1939</option>
                  
                  <option value="1938">1938</option>
                  
                  <option value="1937">1937</option>
                  
                  <option value="1936">1936</option>
                  
                  <option value="1935">1935</option>
                  
                  <option value="1934">1934</option>
                  
                  <option value="1933">1933</option>
                  
                  <option value="1932">1932</option>
                  
                  <option value="1931">1931</option>
                  
                  <option value="1930">1930</option>
                  
                  <option value="1929">1929</option>
                  
                  <option value="1928">1928</option>
                  
                  <option value="1927">1927</option>
                  
                  <option value="1926">1926</option>
                  
                  <option value="1925">1925</option>
                  
                  <option value="1924">1924</option>
                  
                  <option value="1923">1923</option>
                  
                  <option value="1922">1922</option>
                  
                  <option value="1921">1921</option>
                  
                  <option value="1920">1920</option>
                  
                  <option value="1919">1919</option>
                  
                  <option value="1918">1918</option>
                  
                  <option value="1917">1917</option>
                  
                  <option value="1916">1916</option>
                  
                  <option value="1915">1915</option>
                  
                  <option value="1914">1914</option>
                  
                  <option value="1913">1913</option>
                  
                  <option value="1912">1912</option>
                  
                  <option value="1911">1911</option>
                  
                  <option value="1910">1910</option>
                  
                  <option value="1909">1909</option>
                  
                  <option value="1908">1908</option>
                  
                  <option value="1907">1907</option>
                  
                  <option value="1906">1906</option>
                  
                  <option value="1905">1905</option>
                  
                  <option value="1904">1904</option>
                  
                  <option value="1903">1903</option>
                  
                  <option value="1902">1902</option>
                  
                  <option value="1901">1901</option>
                  
                  <option value="1900">1900</option>
                </select> 年
                <select name="original[company_foundation_month]" id="original_paramCompanyEstablishMonth" class="yjChkValEmpty">
                  <option value="">月</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select> 月
              </p>
              
              <p class="errorField" id="original_paramCompanyEstablishError"></p>
              
              <p class="hidewrrap formHint" id="HintCompanyEstablish" style="height: 1px;">
                登記簿の記載日を入力してください。
              </p>
            </div>
          </div>
          


          
          <div class="ctrlHolder ClearFix">
            <div class="AreaL">
              <p><label for="original_paramCompanyCapital">資本金</label><em class="yjMastMark">必須</em><br><em>（半角数字）</em></p>
            </div>
            <div class="AreaR">
              <p>
                <input name="original[company_capital]" type="text" id="original_paramCompanyCapital" placeholder="例）1000" style="width: 9em;" class="yjChkValEmpty yjChkValNumber imeOff" maxlength="10" value=""> 万円
                <span class="okField" id="original_paramCompanyCapitalOK"></span>
              </p>
              
              <p class="errorField" id="original_paramCompanyCapitalError"></p>
              
            </div>
          </div>
          

        </div>
        


        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="original_paramCompanyOneBeforeSales">売上高（前期）</label><em class="yjOptionMark">任意</em><br><em>（半角数字）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="original[company_sales]" type="text" id="original_paramCompanyOneBeforeSales" placeholder="例）10" style="width: 9em;" class="yjChkValNumber imeOff" maxlength="8" value=""> 百万円
            </p>
            
            <p class="errorField" id="original_paramCompanyOneBeforeSalesError"><span style="display:block;height:0;overflow:hidden;">&nbsp;</span></p>
            
          </div>
        </div>
      </div>
    </fieldset>
    <fieldset class="ClearFix">
      <p class="yjCategoryTitle"><legend>代表者情報</legend></p>

      <div class="yjMainArea">

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p>
              <label>代表者名</label><em class="yjMastMark">必須</em><br><em>（全角）</em></p>
          </div>
          <div class="AreaR">
            <p>
              姓：<input name="original[president_name_sei]" type="text" id="original_paramRepresentativePresidentNameLast" placeholder="例）矢風" class="yjChkValEmpty yjChkValSHPRepresentative imeOn" maxlength="14" value="">&nbsp;
              名：<input name="original[president_name_mei]" type="text" id="original_paramRepresentativePresidentNameFirst" placeholder="例）太郎" class="yjChkValEmpty yjChkValSHPRepresentative imeOn" maxlength="14" value="">
              <span class="okField" id="original_paramRepresentativePresidentNameOK"></span>
            </p>
            
            <p class="errorField" id="original_paramRepresentativePresidentNameError"></p>
            
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p>
              <label>代表者名フリガナ</label><em class="yjMastMark">必須</em><br><em>（全角カタカナ）</em></p>
          </div>
          <div class="AreaR">
            <p>
              セイ：<input name="original[president_name_kana_sei]" type="text" id="original_paramRepresentativePresidentNameLastKana" placeholder="例）ヤフウ" class="yjChkValFullKanaSHP yjChkValEmpty imeOn" maxlength="14" value="">&nbsp;
              メイ：<input name="original[president_name_kana_mei]" type="text" id="original_paramRepresentativePresidentNameFirstKana" placeholder="例）タロウ" class="yjChkValFullKanaSHP yjChkValEmpty imeOn" maxlength="14" value="">
              <span class="okField" id="original_paramRepresentativePresidentNameKanaOK"></span>
            </p>
            
            <p class="errorField" id="original_paramRepresentativePresidentNameKanaError"></p>
            
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label>代表者連絡先</label><em class="yjMastMark">必須</em></p>
          </div>
          <div class="AreaR">
            <p>
              <label><input name="original[president_adrs_flg]" type="radio" id="original_president_adrs_flg1" value="0" checked="checked"> 会社情報と同じ</label><br>
              <label><input name="original[president_adrs_flg]" type="radio" id="original_president_adrs_flg2" value="1"> 代表者自宅住所を個別に設定する</label>
            </p>
          </div>
        </div>
        

        
        <div id="yjHydeAreaPresident" class="hidewrrap" style="height: 1px; display: none;">


          
          <div class="yjSubInputBox ClearFix">
            
            <div class="yjSubInputBoxArrow">&nbsp;</div>
            

            
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="original_paramRepresentativeZip">郵便番号</label><em class="yjMastMark">必須</em><br><em>（半角数字）</em></p>
              </div>
              <div class="AreaR">
                <p>
                  <input name="original[president_zip]" type="text" id="original_paramRepresentativeZip" placeholder="例）102-8282" class="yjChkValEmpty yjChkValNumHyp yjChkValZipHyphen imeOff" value="">
                  <input name="original[president_zip1]" type="hidden" id="original_paramRepresentativeZip1" value="">
                  <input name="original[president_zip2]" type="hidden" id="original_paramRepresentativeZip2" value="">
                  <span class="okField" id="original_paramRepresentativeZipOK"></span>
                  <span class="okField" id="original_paramRepresentativeZipSending"></span>
                </p>
                
                <p class="errorField" id="original_paramRepresentativeZipError"></p>
                
                
                <p class="errorField" id="original_paramRepresentativeZipAjaxError"></p>
                
              </div>
            </div>
          
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="original_paramRepresentativePref">都道府県</label><em class="yjMastMark">必須</em></p>
              </div>
              <div class="AreaR">
                <p>
                  <select name="original[president_pref]" id="original_paramRepresentativePref" class="yjChkValEmpty">
                    <option value="" selected="selected">選択してください</option>
                    <optgroup label="北海道">
                      <option value="北海道">北海道</option>
                    </optgroup><optgroup label="東北">
                      <option value="青森県">青森県</option>
                      <option value="秋田県">秋田県</option>
                      <option value="岩手県">岩手県</option>
                      <option value="山形県">山形県</option>
                      <option value="宮城県">宮城県</option>
                      <option value="福島県">福島県</option>
                    </optgroup><optgroup label="関東">
                      <option value="栃木県">栃木県</option>
                      <option value="群馬県">群馬県</option>
                      <option value="茨城県">茨城県</option>
                      <option value="埼玉県">埼玉県</option>
                      <option value="千葉県">千葉県</option>
                      <option value="東京都">東京都</option>
                      <option value="神奈川県">神奈川県</option>
                      <option value="山梨県">山梨県</option>
                    </optgroup><optgroup label="甲信越">
                      <option value="長野県">長野県</option>
                      <option value="新潟県">新潟県</option>
                    </optgroup><optgroup label="北陸">
                      <option value="富山県">富山県</option>
                      <option value="石川県">石川県</option>
                      <option value="福井県">福井県</option>
                    </optgroup><optgroup label="東海">
                      <option value="静岡県">静岡県</option>
                      <option value="岐阜県">岐阜県</option>
                      <option value="愛知県">愛知県</option>
                      <option value="三重県">三重県</option>
                    </optgroup><optgroup label="近畿">
                      <option value="和歌山県">和歌山県</option>
                      <option value="奈良県">奈良県</option>
                      <option value="滋賀県">滋賀県</option>
                      <option value="京都府">京都府</option>
                      <option value="大阪府">大阪府</option>
                      <option value="兵庫県">兵庫県</option>
                    </optgroup><optgroup label="中国">
                      <option value="鳥取県">鳥取県</option>
                      <option value="岡山県">岡山県</option>
                      <option value="島根県">島根県</option>
                      <option value="広島県">広島県</option>
                      <option value="山口県">山口県</option>
                    </optgroup><optgroup label="四国">
                      <option value="徳島県">徳島県</option>
                      <option value="香川県">香川県</option>
                      <option value="愛媛県">愛媛県</option>
                      <option value="高知県">高知県</option>
                    </optgroup><optgroup label="九州">
                      <option value="福岡県">福岡県</option>
                      <option value="佐賀県">佐賀県</option>
                      <option value="長崎県">長崎県</option>
                      <option value="熊本県">熊本県</option>
                      <option value="大分県">大分県</option>
                      <option value="宮崎県">宮崎県</option>
                      <option value="鹿児島県">鹿児島県</option>
                    </optgroup><optgroup label="沖縄">
                      <option value="沖縄県">沖縄県</option>
                    </optgroup>
                  </select>
                  <span class="okField" id="original_paramRepresentativePrefOK"></span>
                </p>
                
                <p class="errorField" id="original_paramRepresentativePrefError"></p>
                
              </div>
            </div>
            


            
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="original_paramRepresentativeAddress1">市区町村</label><em class="yjMastMark">必須</em><br><em>（全角）</em></p>
              </div>
              <div class="AreaR">
                <p>
                  <input name="original[president_address1]" type="text" id="original_paramRepresentativeAddress1" placeholder="例）千代田区" class="yjChkValEmpty imeOn" maxlength="45" value="">
                  <span class="okField" id="original_paramRepresentativeAddress1OK"></span>
                </p>
                
                <p class="errorField" id="original_paramRepresentativeAddress1Error"></p>
                
              </div>
            </div>
            


            
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="original_paramRepresentativeAddress2">町・字名</label><em class="yjMastMark">必須</em><br><em>（全角）</em></p>
              </div>
              <div class="AreaR">
                <p>
                  <input name="original[president_address2]" type="text" id="original_paramRepresentativeAddress2" placeholder="例）紀尾井町" class="yjChkValEmpty imeOn" maxlength="45" value="">
                  <span class="okField" id="original_paramRepresentativeAddress2OK"></span>
                </p>
                
                <p class="errorField" id="original_paramRepresentativeAddress2Error"></p>
                
              </div>
            </div>
            


            
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="original_paramRepresentativeAddress3">丁目・番地・号</label><em class="yjMastMark">必須</em><br><em>（全角）</em></p>
              </div>
              <div class="AreaR">
                <p>
                  <input name="original[president_address3]" type="text" id="original_paramRepresentativeAddress3" placeholder="例）1-3" class="yjChkValEmpty imeOn" maxlength="40" value="">
                  <span class="okField" id="original_paramRepresentativeAddress3OK"></span>
                </p>
                
                <p class="errorField" id="original_paramRepresentativeAddress3Error"></p>
                
              </div>
            </div>
            


            
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="original_paramRepresentativeBuild">ビル名</label><em class="yjOptionMark">任意</em><br><em>（全角）</em></p>
              </div>
              <div class="AreaR">
                <p>
                  <input name="original[president_address4]" type="text" id="original_paramRepresentativeBuild" placeholder="例）紀尾井町タワー" class="imeOn" maxlength="40" value="">
                </p>
                
                <p class="errorField" id="original_paramRepresentativeBuildError"></p>
                
              </div>
            </div>
            


          </div>
        </div>
        


        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="original_paramRepresentativeBirthDateInput">代表者生年月日</label><em class="yjMastMark">必須</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="original[president_birthday_input]" type="text" id="original_paramRepresentativeBirthDateInput" placeholder="例）1980/05/01" style="width: 10em;" class="yjChkValEmpty yjChkValRange-8-10 imeOff" value="">
              <input name="original[president_birthday]" type="hidden" id="original_paramRepresentativeBirthDate" value="">
              <span class="okField" id="original_paramRepresentativeBirthDateOK"></span>
            </p>
            
            <p class="errorField" id="original_paramRepresentativeBirthDateError"></p>
            
          </div>
        </div>
        
      </div>
    </fieldset>
    <fieldset class="ClearFix">
      <p class="yjCategoryTitle"><legend>管理者情報</legend></p>

      <div class="yjMainArea">

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label>管理者名</label><em class="yjMastMark">必須</em></p>
          </div>
          <div class="AreaR">
            <p>
              <label><input type="radio" name="InAdminName_name" id="InAdminName1_flg1" data-rapid_p="27" value="0" checked="checked">代表者氏名と同じ</label><br>
              <label><input type="radio" name="InAdminName_name" id="InAdminName1_flg2" data-rapid_p="28" value="1">管理者氏名を個別に設定する</label>
            </p>
          </div>
        </div>
        <div id="yjHydeAreaAdminName" class="hidewrrap" style="height: 1px; display: none;">
          <div class="yjSubInputBox ClearFix">
            <div class="yjSubInputBoxArrow">&nbsp;</div>
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="InAdminName1">管理者名</label><em class="yjMastMark">必須</em><br><em>（全角）</em></p>
              </div>
              <div class="AreaR">
                <p>
                  姓：<input name="input_psn_sei" type="text" id="InAdminName1" placeholder="例）矢風" class="yjChkValEmpty imeOn" maxlength="15" value="">&nbsp;
                  名：<input name="input_psn_mei" type="text" id="InAdminName2" placeholder="例）太郎" class="yjChkValEmpty imeOn" maxlength="15" value="">
                  <span class="okField" id="InAdminNameOK"></span>
                </p>
                <p class="errorField" id="InAdminNameError">
                  
                  
                </p>
                <p class="hidewrrap formHint" id="HintdminName" style="height: 1px;">
                  個人事業主様は、代表者情報と同じ情報を入力してください。
                </p>
              </div>
            </div>
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="InAdminKana1">管理者名フリガナ</label><em class="yjMastMark">必須</em><br><em>（全角カタカナ）</em></p>
              </div>
              <div class="AreaR">
                <p>
                  セイ：<input name="input_psn_sei_kana" type="text" id="InAdminKana1" placeholder="例）ヤフウ" class="yjChkValFullKana yjChkValEmpty imeOn" maxlength="15" value="">&nbsp;
                  メイ：<input name="input_psn_mei_kana" type="text" id="InAdminKana2" placeholder="例）タロウ" class="yjChkValFullKana yjChkValEmpty imeOn" maxlength="15" value="">
                  <span class="okField" id="InAdminKanaOK"></span>
                </p>
                <p class="errorField" id="InAdminKanaError">
                  
                  
                </p>
              </div>
            </div>
          </div>
        </div>

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="InAdminMail">メールアドレス</label><em class="yjMastMark">必須</em><br><em>（半角英数）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="input_psn_mail" type="text" id="InAdminMail" placeholder="例）yahootarou@example.com" class="yjChkValEmpty yjChkValEmail imeOff" maxlength="320" value="">
              <span class="okField" id="InAdminMailOK"></span>
            </p>
            
            <p class="errorField" id="InAdminMailError"></p>
            
          </div>
        </div>
        


        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label>管理者連絡先</label><em class="yjMastMark">必須</em></p>
          </div>
          <div class="AreaR">
            <p>
              <label><input name="input_psn_adrs_flg" type="radio" id="InChoiceAddress1" value="0" checked="checked"> 会社情報と同じ</label><br>
              <label><input name="input_psn_adrs_flg" type="radio" id="InChoiceAddress2" value="1"> 管理者の連絡先を個別に設定する</label>
            </p>
          </div>
        </div>
        


        
        <div id="yjHydeAreaAdmin" class="hidewrrap" style="height: 1px; display: none;">


          
          <div class="yjSubInputBox ClearFix">
            
            <div class="yjSubInputBoxArrow">&nbsp;</div>
            

            
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="InAdminPostNum">郵便番号</label><em class="yjMastMark">必須</em><br><em>（半角数字）</em></p>
              </div>
              <div class="AreaR">
                <p>
                  <input name="input_psn_zip" type="text" id="InAdminPostNum" placeholder="例）102-8282" class="yjChkValEmpty yjChkValNumHyp yjChkValZipHyphen imeOff" value="">
                  <input name="input_psn_zip1" type="hidden" id="InAdminPostNum1" value="">
                  <input name="input_psn_zip2" type="hidden" id="InAdminPostNum2" value="">
                  <span class="okField" id="InAdminPostNumOK"></span>
                  <span class="okField" id="InAdminPostNumSending"></span>
                </p>
                
                <p class="errorField" id="InAdminPostNumError"></p>
                
                
                <p class="errorField" id="InAdminPostNumAjaxError"></p>
                
              </div>
            </div>
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="InAdminPref">都道府県</label><em class="yjMastMark">必須</em></p>
              </div>
              <div class="AreaR">
                <p>
                  <select name="input_psn_pref" id="InAdminPref" class="yjChkValEmpty">
                    <option value="" selected="selected">選択してください</option>
                    <optgroup label="北海道">
                      <option value="北海道">北海道</option>
                    </optgroup><optgroup label="東北">
                      <option value="青森県">青森県</option>
                      <option value="秋田県">秋田県</option>
                      <option value="岩手県">岩手県</option>
                      <option value="山形県">山形県</option>
                      <option value="宮城県">宮城県</option>
                      <option value="福島県">福島県</option>
                    </optgroup><optgroup label="関東">
                      <option value="栃木県">栃木県</option>
                      <option value="群馬県">群馬県</option>
                      <option value="茨城県">茨城県</option>
                      <option value="埼玉県">埼玉県</option>
                      <option value="千葉県">千葉県</option>
                      <option value="東京都">東京都</option>
                      <option value="神奈川県">神奈川県</option>
                      <option value="山梨県">山梨県</option>
                    </optgroup><optgroup label="甲信越">
                      <option value="長野県">長野県</option>
                      <option value="新潟県">新潟県</option>
                    </optgroup><optgroup label="北陸">
                      <option value="富山県">富山県</option>
                      <option value="石川県">石川県</option>
                      <option value="福井県">福井県</option>
                    </optgroup><optgroup label="東海">
                      <option value="静岡県">静岡県</option>
                      <option value="岐阜県">岐阜県</option>
                      <option value="愛知県">愛知県</option>
                      <option value="三重県">三重県</option>
                    </optgroup><optgroup label="近畿">
                      <option value="和歌山県">和歌山県</option>
                      <option value="奈良県">奈良県</option>
                      <option value="滋賀県">滋賀県</option>
                      <option value="京都府">京都府</option>
                      <option value="大阪府">大阪府</option>
                      <option value="兵庫県">兵庫県</option>
                    </optgroup><optgroup label="中国">
                      <option value="鳥取県">鳥取県</option>
                      <option value="岡山県">岡山県</option>
                      <option value="島根県">島根県</option>
                      <option value="広島県">広島県</option>
                      <option value="山口県">山口県</option>
                    </optgroup><optgroup label="四国">
                      <option value="徳島県">徳島県</option>
                      <option value="香川県">香川県</option>
                      <option value="愛媛県">愛媛県</option>
                      <option value="高知県">高知県</option>
                    </optgroup><optgroup label="九州">
                      <option value="福岡県">福岡県</option>
                      <option value="佐賀県">佐賀県</option>
                      <option value="長崎県">長崎県</option>
                      <option value="熊本県">熊本県</option>
                      <option value="大分県">大分県</option>
                      <option value="宮崎県">宮崎県</option>
                      <option value="鹿児島県">鹿児島県</option>
                    </optgroup><optgroup label="沖縄">
                      <option value="沖縄県">沖縄県</option>
                    </optgroup>
                  </select>
                  <span class="okField" id="InAdminPrefOK"></span>
                </p>
                
                <p class="errorField" id="InAdminPrefError"></p>
                
              </div>
            </div>
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="InAdminAddress1">市区町村</label><em class="yjMastMark">必須</em><br><em>（全角）</em></p>
              </div>
              <div class="AreaR">
                <p>
                  <input name="input_psn_address1" type="text" id="InAdminAddress1" placeholder="例）千代田区" class="yjChkValEmpty imeOn" maxlength="45" value="">
                  <span class="okField" id="InAdminAddress1OK"></span>
                </p>
                
                <p class="errorField" id="InAdminAddress1Error"></p>
                
              </div>
            </div>
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="InAdminAddress2">町・字名</label><em class="yjMastMark">必須</em><br><em>（全角）</em></p>
              </div>
              <div class="AreaR">
                <p>
                  <input name="input_psn_address2" type="text" id="InAdminAddress2" placeholder="例）紀尾井町" class="yjChkValEmpty imeOn" maxlength="45" value="">
                  <span class="okField" id="InAdminAddress2OK"></span>
                </p>
                
                <p class="errorField" id="InAdminAddress2Error"></p>
                
              </div>
            </div>
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="InAdminAddress3">丁目・番地・号</label><em class="yjMastMark">必須</em><br><em>（全角）</em></p>
              </div>
              <div class="AreaR">
                <p>
                  <input name="input_psn_address3" type="text" id="InAdminAddress3" placeholder="例）1-3" class="yjChkValEmpty imeOn" maxlength="40" value="">
                  <span class="okField" id="InAdminAddress3OK"></span>
                </p>
                
                <p class="errorField" id="InAdminAddress3Error"></p>
                
              </div>
            </div>
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="InAdminAddress4">ビル名</label><em class="yjOptionMark">任意</em><br><em>（全角）</em></p>
              </div>
              <div class="AreaR">
                <p>
                  <input name="input_psn_build" type="text" id="InAdminAddress4" placeholder="例）紀尾井町タワー" class="imeOn" maxlength="40" value="">
                </p>
                
                <p class="errorField" id="InAdminAddress4Error"></p>
                
              </div>
            </div>
            


            
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="InAdminTel1">電話番号</label><em class="yjMastMark">必須</em><br><em>（半角数字）</em></p>
              </div>
              <div class="AreaR">
                <p>

                  <input name="input_psn_tel1" type="text" id="InAdminTel1" placeholder="例）03" class="yjChkValNumber yjChkValEmpty yjChkValRange-0-5 imeOff" value=""> -
                  <input name="input_psn_tel2" type="text" id="InAdminTel2" placeholder="例）1234" class="yjChkValNumber yjChkValEmpty yjChkValRange-0-5 imeOff" value=""> -
                  <input name="input_psn_tel3" type="text" id="InAdminTel3" placeholder="例）5678" class="yjChkValNumber yjChkValEmpty yjChkValRange-0-5 imeOff" value="">
                  <input name="input_psn_tel_all" type="hidden" id="InAdminTelAll" class="yjChkValRange-10-11 imeOff" value="1234567890">
                  <span class="okField" id="InAdminTelOK"></span>
                </p>
                
                <p class="errorField" id="InAdminTelError"></p>
                
              </div>
            </div>
            

          </div>
        </div>
        
      </div>
    </fieldset>
    

  </div>
</div>
      <div>
  
  <a name="yjPayTop"></a>
  <fieldset class="ClearFix">
    <p class="yjCategoryTitle">
      <legend>決済情報</legend>
    </p>
    <div class="ctrlHolder ClearFix">
      <div class="AreaL">
        <p><label>お支払い方法の登録</label><em class="yjMastMark">必須</em></p>
      </div>
      <div class="AreaR">
        <p>
          <label>
            <input name="pay_select_type" type="radio" id="InChoicePay1" value="C" checked="checked">
            クレジットカードによるお支払い</label>
        </p>
      </div>
    </div>
      <div id="yjHydeAreaPayCard" class="hidewrrap" style="display: block; height: auto;">

        <div class="yjMainArea">

          
          <div class="yjSubInputBox ClearFix">

            
            <div class="yjSubInputBoxArrow">&nbsp;</div>  
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="InCardNum">カード番号</label><em class="yjMastMark">必須</em><br><em>（半角数字）</em></p>
              </div>
              <div class="AreaR">
                <p><noscript>例）1234567890123456<br></noscript>
                <input name="input_pay_card_no" type="text" id="InCardNum" placeholder="例）1234567890123456" class="yjChkValNumber yjChkValEmpty yjChkValRange-14-16 imeOff" autocomplete="off">
                <span class="okField" id="InCardNumOK"></span>
                </p>
                
                <p class="errorField" id="InCardNumError"></p>
                
                <p class="hidewrrap formHint" id="HintCardNum" style="height: 1px;">
                  一部のデビットカードはご利用いただけません。
                </p>
              </div>
            </div>
            

            
            <div class="mt05em">
              <div class="ctrlHolder ClearFix">
                <div class="AreaL">
                  <p><label for="InCardLimit1">有効期限</label><em class="yjMastMark">必須</em><br><em>（半角数字）</em></p>
                </div>
                <div class="AreaR">
                  <p id="CardCaption"><label id="CardM" for="InCardLimit1">MONTH</label><label id="CardY" for="InCardLimit2">YEAR</label>
                  </p>
                  <p><noscript>例）04/25<br></noscript>
                  <input name="input_pay_card_valid_term_mm" type="text" id="InCardLimit1" placeholder="例）04" class="yjChkValNumber yjChkValEmpty yjChkValRange-2-2 imeOff" autocomplete="off"> /
                  <input name="input_pay_card_valid_term_yy" type="text" id="InCardLimit2" placeholder="例）25" class="yjChkValNumber yjChkValEmpty yjChkValRange-2-2 imeOff" autocomplete="off">
                  <span class="okField" id="InCardLimitOK"></span>
                  </p>
                  
                  <p class="errorField" id="InCardLimitError"></p>
                  
                </div>
              </div>
            </div>   
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="InCardName">カード名義</label><em class="yjMastMark">必須</em><br><em>（半角）</em></p>
              </div>
              <div class="AreaR">
                <p><noscript>例）TAROU YAHOO<br></noscript>
                <input name="input_pay_card_account_holder_name" type="text" id="InCardName" placeholder="例）TAROU YAHOO" maxlength="32" class="yjChkValEmpty imeOff" autocomplete="off"><span class="okField" id="InCardNameOK"></span>
                </p>
                
                <p class="errorField" id="InCardNameError"></p>
                
              </div>
            </div>
            <div class="ctrlHolder ClearFix">
              <div class="AreaL">
                <p><label for="InCardPass">セキュリティーコード</label><em class="yjMastMark">必須</em><br><em>（半角数字）</em></p>
              </div>
              <div class="AreaR">
                <p>
                  <input name="input_pay_card_security_cd" type="password" id="InCardPass" class="yjChkValNumber yjChkValEmpty yjChkValRange-3-4" autocomplete="off"><span class="okField" id="InCardPassOK"></span>
                </p>
                
                <p class="errorField" id="InCardPassError"></p>
              </div>
            </div>        
            <input type="hidden" name="pay_card_token" id="InCardToken" value="">
          </div>
        </div>
      
      </div>
      <script src="./お申し込み情報の入力 - Yahoo! JAPAN_files/client.js.ダウンロード"></script>
      <p hidden="" id="cardTokenKey">B0Kn5vQGOR</p>
      <script charset="utf-8" src="./お申し込み情報の入力 - Yahoo! JAPAN_files/card_tokenization-1.0.0-min.js.ダウンロード" type="text/javascript"></script>
  </fieldset>
  
</div>   
        <div>
    <fieldset class="ClearFix">
      <p class="yjCategoryTitle">
        <legend>受取口座情報</legend>
      </p>

      <div class="yjMainArea">
        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p>
              <label>金融機関</label><em class="yjMastMark">必須</em><br>
            </p>
          </div>
          <div class="AreaR">
            <p>
              <button name="BtnSearchBank" type="button" style="float:left; text-indent: 100%; white-space: nowrap; overflow: hidden;" id="BtnSearchBank">
                金融機関名検索
              </button>
              <span id="InCashBackBankOK" class="okField"></span>
            </p>
            <br style="clear: both;">
            <table class="InCashBackBank">
              <tbody><tr>
                <th>金融機関名</th>
                <td id="InCashBackBank1Table"></td>
              </tr>
              <tr>
                <th>支店名</th>
                <td id="InCashBackBank2Table"></td>
              </tr>
            </tbody></table>
            <input name="bkname_rec" type="hidden" id="InCashBackBank1" class="yjChkValEmpty imeOn" maxlength="30" value="">
            <input name="bksubname_rec" type="hidden" id="InCashBackBank2" class="yjChkValEmpty imeOn" maxlength="60" value="">

            
            <p class="errorField" id="InCashBackBankError"></p>
            
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label>口座種別</label><em class="yjMastMark">必須</em></p>
          </div>
          <div class="AreaR">
            <p>
              <label><input name="input_acc_bank_account_type" type="radio" id="InCashBackType1" value="1" checked="checked">普通</label>&nbsp;&nbsp;
              <label><input name="input_acc_bank_account_type" type="radio" id="InCashBackType2" value="2">当座</label>&nbsp;&nbsp;
              <label><input name="input_acc_bank_account_type" type="radio" id="InCashBackType9" value="9">その他</label>
            </p>
            
            <p class="errorField" id="InCashBackTypeError"></p>
            
          </div>
        </div>
        


        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="InCashBackNum">口座番号</label><em class="yjMastMark">必須</em><br><em>（半角数字）</em></p>
          </div>
          <div class="AreaR">
            <p>
            <noscript>例）1234567<br></noscript>
            <input type="text" class="yjChkValNumber yjChkValEmpty imeOff yjChkValRange-7-7" placeholder="例）1234567" id="InCashBackNum" name="input_acc_bank_account_no" value="">
            <span id="InCashBackNumOK" class="okField"></span>
            </p>
            
            <p class="errorField" id="InCashBackNumError"></p>
            
            <p class="hidewrrap formHint" id="HintCashBackNum" style="height: 1px;">
              7けたに満たない場合は先頭に0をつけてください。
            </p>
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="original_paramBankAccountName">口座名義</label><em class="yjMastMark">必須</em><br><em>（全角）</em>
            </p>
          </div>
          <div class="AreaR">
            <p>
              <input type="text" class="yjChkValEmpty imeOn" placeholder="例）株式会社矢風商事" id="original_paramBankAccountName" name="original[bank_account_name]" maxlength="30" value="">
              <span id="original_paramBankAccountNameOK" class="okField"></span>
            </p>
            
            <p class="errorField" id="original_paramBankAccountNameError"></p>
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="InCashBackName">口座名義フリガナ</label><em class="yjMastMark">必須</em><br><em>（全角カタカナ）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input type="text" class="yjChkValEmpty imeOn" placeholder="例）カ）ヤフウショウジ" id="InCashBackName" maxlength="60" name="input_acc_bank_account_name_kana" value="">
              <span id="InCashBackNameOK" class="okField"></span>
            </p>
            
            <p class="errorField" id="InCashBackNameError"></p>
          
          </div>
        </div>
        
      </div>
    </fieldset>
  <input name="acc_select_type" type="hidden" value="A">
</div>
      <div>

  <div id="fstr">

    
    <fieldset class="ClearFix">
      <p class="yjCategoryTitle"><legend>ストア情報</legend></p>


      <div class="yjMainArea">

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p>
              <label for="original_paramStoreStoreName">ストア名</label><em class="yjMastMark">必須</em><br><em>（全角・半角英数字）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="original[store_name]" type="text" id="original_paramStoreStoreName" placeholder="例）矢風ストア" class="yjChkValEmpty imeOn" value="">
              <span class="okField" id="original_paramStoreStoreNameOK"></span>
            </p>
            
            <p class="errorField" id="original_paramStoreStoreNameError"></p>
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p>
              <label for="original_paramStoreStoreNameKana">ストア名フリガナ</label><em class="yjMastMark">必須</em><br><em>（全角カタカナ）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="original[store_name_kana]" type="text" id="original_paramStoreStoreNameKana" placeholder="例）ヤフウストア" class="yjChkValEmpty yjChkValFullKanaSHP imeOn" maxlength="32" value="">
              <span class="okField" id="original_paramStoreStoreNameKanaOK"></span>
            </p>
            
            <p class="errorField" id="original_paramStoreStoreNameKanaError"></p>
            
          </div>
        </div>
        

        
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p>
              <label for="original_paramStoreSellerID">ストアアカウント</label><em class="yjMastMark">必須</em><br><em>（半角英数字）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="original[store_account]" type="text" id="original_paramStoreSellerID" placeholder="例）yafuu-store" class="yjChkValEmpty imeOff" maxlength="20" value="">
              <span class="okField" id="original_paramStoreSellerIDOK"></span>
            </p>
            
            <p class="errorField" id="original_paramStoreSellerIDError"></p>
          </div>
          <div id="yjJsPreview_url" class="yjPreviewInputBox ClearFix" style="display:none;">
            <div class="yjPreviewInputArrow">&nbsp;</div>
            <div class="ctrlHolder">
              <div class="AreaL"><label>Yahoo!ショッピング上の貴社ストアURL</label></div>
              <div class="AreaR">
                <p class="yjJsPreview_url_bd yjWordBreak">https://shopping.yahoo.co.jp/<span id="storeSellerIDPreview" class="formHintAttention">ストアアカウント</span></p>
              </div>
            </div>
          </div>
        </div>
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p><label for="original_paramStoreCsTel1">商品購入者向けの連絡先電話番号</label><em class="yjMastMark">必須</em><br><em>（半角数字）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="original[store_buyer_tel1]" type="text" id="original_paramStoreCsTel1" placeholder="例）03" class="yjChkValEmpty yjChkValNumber yjChkValRange-0-5 imeOff" value=""> -
              <input name="original[store_buyer_tel2]" type="text" id="original_paramStoreCsTel2" placeholder="例）1234" class="yjChkValEmpty yjChkValNumber yjChkValRange-0-5 imeOff" value=""> -
              <input name="original[store_buyer_tel3]" type="text" id="original_paramStoreCsTel3" placeholder="例）5678" class="yjChkValEmpty yjChkValNumber yjChkValRange-0-5 imeOff" value="">
              <span class="okField" id="original_store_buyer_telOK"></span>
              <input name="original[store_buyer_tel_all]" type="hidden" id="original_paramStoreCsTelAll" class="imeOff yjChkValRange-10-11" value="">
            </p>    
            <p class="errorField" id="original_store_buyer_telError"></p>        
          </div>
        </div>
        <div class="ctrlHolder ClearFix">
          <div class="AreaL">
            <p>
              <label for="original_paramItemUrl">貴社ストアURL</label><em class="yjOptionMark">任意</em><br><em>（半角英数字）</em></p>
          </div>
          <div class="AreaR">
            <p>
              <input name="original[product_url]" type="text" id="original_paramItemUrl" placeholder="例）https://www.yahoo.co.jp/" style="width: 23em;" class="imeOff yjChkValSHPUrl" maxlength="1024" value="">
            </p>   
            <p class="errorField" id="original_paramItemUrlError"><span style="display:block;height:0;overflow:hidden;">&nbsp;</span></p>
          </div>
        </div>
      </div>
    </fieldset>
    </div>
</div>
    <div id="SubmitArea" class="JsOff">
      <hr>
        <input name="next" type="submit" value="入力内容の確認" class="btnSubmit" id="btnSubmit">
      </p>
    </div>
  </form>
</body></html>