<style type="text/css">
.nextgame caption, .nextgame td, .nextgame th {font-family:sans-serif;font-size:11px;color:000;white-space:nowrap;}
.nextgame table{border:none;border-collapse:collapse;border:1px solid #ccc;margin-bottom:0.5em;}
.nextgame .lost  {color: #900;}
.nextgame .win  {color: #090;}
.nextgame .draw  {color: #999;}
.nextgame .noResult {color: #000;}
.nextgame .result  {font-weight:bold;font-size:160%;}
.nextgame ul {margin:1em 0;padding:0;list-style:none;}
.nextgame caption { background:#69c;color:#fff;font-weight:bold;margin-bottom:0.3em;padding:0.2em;}
.nextgame acronym { cursor:help;border-bottom:1px dotted;color:blue; }
.nextgame small{font-size:11px;}
</style>
<table class="nextgame">
  <tr>
    <td>
      <table width="100%">
        <caption><!--gameTxt--></caption>
        <tr>
         <th><!--gameDate--> <!--gameTime--></th>
        </tr>
        <tr>
          <td align="center"><!--homeName--></td>
        </tr>
        <tr>
          <td align="center"><!--imgHomeBig-->&nbsp;-&nbsp;<!--imgGuestBig--></td>
        </tr>
        <tr>
          <td align="center"><!--guestName--></td>
        </tr>
        <tr>
          <td><small><!--gameNote--></small></td>
        </tr>
        <tr>
          <th><!--matchesTxt--></th>
        </tr>
        <tr>
          <td align="center"><!--winCount--> / <!--drawCount--> / <!--lostCount--> (<!--winTxt-->/<!--drawTxt-->/<!--lostTxt-->)</td>
        </tr>
        <tr>
          <th>  
            <table align="center" border="0" cellpadding="0" cellspacing="0">
             	<tr>
                <th bgcolor="#009900" height="7" width="<!--winWidth-->"></th>
                <th bgcolor="#999999" height="7" width="<!--drawWidth-->"></th>
                <th bgcolor="#990000" height="7" width="<!--lostWidth-->"></th>
             	</tr>
            </table>
          </th>
        </tr>
        <tr>
          <td align="center">
            <ul>
        <!-- BEGIN matches -->
        <li class="<!--class-->"><!--date--> <!--time--> <!--hTore-->:<!--gTore--> (<!--where-->) <small><!--matchingName--></small></li>
        <!-- END matches -->
           </ul>
         </td>
       </tr>
       <tr>
         <td align="right"><small><!--ligaDatum-->&nbsp;<!--copy--></small></td>
       </tr>
      </table>
      <!-- BEGIN previous -->
      <table width="100%">
        <caption><!--previous_gameTxt--></caption>
        <tr>
         <th><!--previous_gameDate--> <!--previous_gameTime--></th>
        </tr>
        <tr>
          <td align="center"><!--previous_imgHomeSmall--></td>
        </tr>
        <tr>
          <td align="center"><!--previous_homeName--></td>
        </tr>
        <tr>
          <th class="result"><!--previous_hTore--> : <!--previous_gTore--></th>
        </tr>
        <tr>
          <td align="center"><!--previous_guestName--></td>
        </tr>
        <tr>
          <td align="center"><!--previous_imgGuestSmall--></td>
        </tr>
      </table>
      <!-- END previous -->
    </td>
  </tr>
</table>