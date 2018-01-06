@msg=""
@RED="\033[38;5;202m"
@GRN="\033[38;5;120m"
@BLU="\033[38;5;33m"
@CYN="\033[38;5;81m"
@PUR="\033[38;5;92m"
@YLW="\033[38;5;214m"
@SKN="\033[38;5;222m"
@BRN="\033[38;5;130m"
@BLK="\033[38;5;40m"
@WHT="\033[38;5;15m"
@GRY="\033[38;5;245m"
@DGY="\033[38;5;250m"
@CLR="\033[m"

if @show_logo then
  splash = <<-HEREDOC
#{@BLU}          ,
#{@BLU}         /|  #{@GRN} _               #{@DGY}W O R D  P R E S S
#{@BLU}       _/_\\_ #{@GRN}>_<  #{@CYN} _______              __
#{@BLU}      .-#{@SKN}\\-/#{@BLU}.  #{@BRN}|   #{@CYN}|       |-----.-----.|__|.--.--.----.-----.
#{@BLU}     /  |#{@WHT}∨#{@BLU}| \\_#{@BRN}|   #{@CYN}|   ----|  _  |      |  |   |  |   _|  -__|
#{@BLU}     \\ \\| |\\_(#{@SKN}/ #{@CYN}  |_______|_____|___|__|  |______|__| |_____|
#{@BLU}     /#{@SKN}(`#{@GRY}______#{@BRN}|#{@GRY}_  #{@CYN}                 |______|
#{@BLU}    /#{@DGY} o(-- #{@YLW},#{@DGY}- --)o                               #{@GRN}ver #{@verCONJURE}                   
#{@BLU} _.'_v,#{@DGY} \\#{@RED} .  #{@RED}, #{@DGY}/
#{@GRY}-------#{@BRN}_#{@YLW}//#{@RED}^^--^#{@YLW}\\\\#{@BRN}_#{@GRY} -------------------------------------------
#{@CYN}    REPO: #{@CLR}#{@branch}                    #{@CYN}DASH: #{@CLR}https://#{@configuredHost}
#{@CYN}     IP : #{@CLR}#{@configuredIP}           #{@CYN}NAME: #{@CLR}#{@configuredName}
#{@GRY}--------------------------------------------------------------
  HEREDOC
  puts splash
end

## EXAMPLE WAY TO OUTPUT LONG STING
@msg = <<MSG
#{@BLU}------------------------------------------------------
#{@GRN} WP_Conjure                             192.168.23.13

   #{@CYN}URLS:
     - magic.app   - magic.app   - magic.app/docs
     - magic.app   - magic.app   - magic.app/target
#{@BLU}------------------------------------------------------#{@CLR}
MSG
