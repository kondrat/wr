							$.fn.isPasswordStrengthField=function(A,B){
								
								return this.each(function(){
									
									if(!A){return }
									
									if(!B){B={}}
									
									var H=$(this);
									
									var J=$(A);
									
									J.append('<span class="pstrength-text"></span>');
									
									var F=J.find(".pstrength-text");
									
									function E(K){
										
										J.children().each(function(){
											
												var L=$(this);
												if(L.hasClass("pstrength-text")){
													if(K){
														L.show()
													}else{
														L.hide()
													}
												}else{
													if(K){
														L.hide()
													}else{
														L.show()
													}
												}
										})
										
									}
									
									function I(L){
											var P=0;
											var N=B.minlength?B.minlength:6;
											if(L.length<N){
												return {
														score:L.length,
														message:_("Too short"),
														className:"password-invalid"
														}
											}
											
											if(B.username){
												var Q=(typeof (B.username)=="function")?B.username():B.username;
												if( Q && ( L.toLowerCase()==Q.toLowerCase() ) ){
													return{
															score:0,
															message:_("Too obvious"),
															className:"password-invalid"}
														}
											}
												
											if( $.inArray(L.toLowerCase(),twttr.BANNED_PASSWORDS)!=-1 ){
												return{score:0,message:_("Too obvious"),className:"password-invalid"}
											}
											
											if(B.requireStrong){
												size=10;
												var K="# ` ~ ! @ $ % ^ & * ( ) - _ = + [ ] { }  | ; : ' \" , . < > / ?".split(" ");
												K=$.map(K,function(R){return"\\"+R}).join("");
												var M=["\\d","[a-z]","[A-Z]","["+K+"]"];
												var O=$.map(M,function(R){return"(?=.*"+R+")"}).join("");
												if(!L.match(new RegExp("("+O+"){10,}"))){
													return{score:0,message:_("Too Weak"),className:"password-invalid"}
												}
											}
										
											P+=L.length*4;
											P+=(D(1,L).length-L.length)*1;
											P+=(D(2,L).length-L.length)*1;
											P+=(D(3,L).length-L.length)*1;
											P+=(D(4,L).length-L.length)*1;
											if( L.match(/(.*[0-9].*[0-9].*[0-9])/) ) {
												P+=5
											}
											if(L.match(/(.*[!@#$%^&*?_~].*[!@#$%^&*?_~])/)){
												P+=5
											}
											if( L.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/) ) {
												P+=10
											}
											if( L.match(/([a-zA-Z])/)&&L.match(/([0-9])/) ) {
												P+=15 
											}
											if( L.match(/([!@#$%^&*?_~])/)&&L.match(/([0-9])/) ) {
												P+=15
											}
											if( L.match(/([!@#$%^&*?_~])/)&&L.match(/([a-zA-Z])/) ) { 
												P+=15
											}
											if( L.match(/^\w+$/)||L.match(/^\d+$/) ) { 
												P-=10
											}
											if( P<0 ){P=0}
											
											if(P>100){P=100}
											
											if(P<34){return{score:P,message:_("Weak"),className:"password-weak"}}
											
											if(P<50){return{score:P,message:_("Good"),className:"password-good"}}
											
											if(P<75) { 
												return{score:P,message:_("Strong"),className:"password-strong"}
											}
											
											return{score:P,message:_("Very Strong"),className:"password-verystrong"}
									}
									
									function D(L,O){
										var K="";
										for( var N=0; N < O.length; N++ ){
											
											var P=true;
											for( var M=0; M<L&&(M+N+L) < O.length; M++ ){
												P=P&&(O.charAt(M+N)==O.charAt(M+N+L))
											}
												
											if(M<L){P=false}
											
											if(P){
												
												N+=L-1;
												P=false
												
											}else{
												
												K+=O.charAt(N)}
												
											}
											return K
									}
									
									function C(K){
										if(K&&J.hasClass(K)){return false}
										J.removeClass("password-weak").removeClass("password-good").removeClass("password-strong").removeClass("password-verystrong").removeClass("password-invalid");
										return true
									}
									
									function G(){
										
										var L=H.val();
														
										if(L.length==0){
											C();
											E(false)
										}else{
											if(L.length){
												E(true)
											}
										}
										
										if(L.length>0){
											var K=I(L);
											F.html(K.message);
											if( C(K.className) ){
												J.addClass(K.className)
											}
										}
									}
									
									H.bind("show-password-meter",function(){J.show()});
									
									H.bind("hide-password-meter",function(){J.hide()});
									
									H.keyup(function(){G()});
									
									H.blur(function(){ 
										if(this.value.length==0){
											C();
											H.trigger("hide-password-meter")
										}
									});
									
									if( H.val() ){
										G();
										J.show();
									}
									
								})
							};