<script type="text/javascript">    
function WalletColorsInit(){
  var walletColors = <?=json_encode(\App\MoneyKeeper\Models\Operation::getWalletColors())?>;
  $('.wallet-selector option').each(function() {
    $(this).css("background-color", '#'+walletColors[$(this).val()]);
  });
  $('.wallet-selector').change(function(){
    $(this).css("background-color", '#'+walletColors[$(this).val()]);
  });
  $('.wallet-selector').each(function(){
    $(this).css("background-color", '#'+walletColors[$(this).val()]);
  });
}
window.onload = function(){
    WalletColorsInit();
};
</script>
