function base64ToAscii(c)
{
    var theChar = 0;
    if (0 <= c && c <= 25){
        theChar = String.fromCharCode(c + 65);
    } else if (26 <= c && c <= 51) {
        theChar = String.fromCharCode(c - 26 + 97);
    } else if (52 <= c && c <= 61) {
        theChar = String.fromCharCode(c - 52 + 48);
    } else if (c == 62) {
        theChar = '+';
    } else if( c == 63 ) {
        theChar = '/';
    } else {
        theChar = String.fromCharCode(0xFF);
    } 
	return (theChar);
}

function base64Encode(str) {
    var result = "";
    var i = 0;
    var sextet = 0;
    var leftovers = 0;
    var octet = 0;

    for (i=0; i < str.length; i++) {
         octet = str.charCodeAt(i);
         switch( i % 3 )
         {
         case 0:
                {
                    sextet = ( octet & 0xFC ) >> 2 ;
                    leftovers = octet & 0x03 ;
                    // sextet contains first character in quadruple
                    break;
                }
          case 1:
                {
                    sextet = ( leftovers << 4 ) | ( ( octet & 0xF0 ) >> 4 );
                    leftovers = octet & 0x0F ;
                    // sextet contains 2nd character in quadruple
                    break;
                }
          case 2:

                {

                    sextet = ( leftovers << 2 ) | ( ( octet & 0xC0 ) >> 6 ) ;
                    leftovers = ( octet & 0x3F ) ;
                    // sextet contains third character in quadruple
                    // leftovers contains fourth character in quadruple
                    break;
                }

         }
         result = result + base64ToAscii(sextet);
         // don't forget about the fourth character if it is there

         if( (i % 3) == 2 )
         {
               result = result + base64ToAscii(leftovers);
         }
    }

    // figure out what to do with leftovers and padding
    switch( str.length % 3 )
    {
    case 0:
        {
             // an even multiple of 3, nothing left to do
             break ;
        }

    case 1:
        {
            // one 6-bit chars plus 2 leftover bits
            leftovers =  leftovers << 4 ;
            result = result + base64ToAscii(leftovers);
            result = result + "==";
            break ;
        }

    case 2:
        {
            // two 6-bit chars plus 4 leftover bits
            leftovers = leftovers << 2 ;
            result = result + base64ToAscii(leftovers);
            result = result + "=";
            break ;
        }

    }

    return (result);

}


function LoginForm(){
    var frm = document.forms.loginform;

    var authinput=frm.authstring;

    var login = frm.login.value;
    var password = frm.password.value;
    
    var host = (frm.host!=null ? frm.host.value : "");
    
    var authstr = (host!="" ? host+":" : "")+login+":"+password;

    if (login.match(/^[a-z0-9_\\\/\@\.\-]{1,24}$/i)==null){
      $('#login').addClass('error_field').focus();
      return (false);
    }

    if (password.match(/^[\S ]+$/i)==null){
      $('#password').addClass('error_field').focus();
      return (false);
    }
	
	$('#login,#password').removeClass('error_field');
    frm.login.value="";
    frm.password.value="";
    frm.btnsubmit.disabled=true;
	frm.btnsubmit.value="Logging on...";

    authstr = base64Encode(authstr);
    authinput.value=authstr;
  
    return (true);
}