// decompression: http://jsutility.pjoneil.net/

function isBlank(A)
   {return A.replace(/\s+/g, "").length == 0;
   }
(function(B)
   {
   function A()
       {var F = jQuery("#signup-form");
        var E = F.find("input, password");
        var D = F.hasClass("validated-by-backend");
        F.find("#user_name").isSignupFormField(
        {validateWith: function(G)
           {return isBlank(G) ? _("Should be a first and last name"): true;
           }
       });
        F.find("#user_screen_name").isScreenNameField();
        F.find("#user_email").isEmailField();
        F.find("#user_user_password").isSignupFormField(        {allowInput:/[^\s]/}).focus(function()
           {           B(this).trigger("show-password-meter");
           }).isPasswordStrengthField(".password-meter", 
        {username: function()
           {return F.find("#user_screen_name").val();
           }
       });
        if (D)
           {E.trigger("align-validation");
           }
        var C = F.find(".fieldWithErrors:eq(0) input");
        if (C.length > 0)
           {C.focus();
           }
        else 
           {F.find("#user_name").focus();
           }
       }
    B(document).ready(A);
   })(jQuery);
(function(A)
   {
   A.fn.isEmailField = function()
       {return this.each(function()
           {var C =/.+@.+\..+/;
            var F = A(this);
            var D = A("#email_info");
            var G = A("#avail_email_check_indicator");
           
            function E()
               {F.trigger("show-info");
                D.hide();
                G.show();
               }
           
            function H()
               {D.show();
                G.hide();
               }
           
            function B()
               {var I = F.val();
                if (I.match(C))
                   {jQuery.ajax( {type: "GET", url: "/users/email_available", data: 
                    {email: I}, dataType: "json", beforeSend: function()
                       {
                       E();
                       }
                   , success: function(J)
                       {                       var K = J.msg;
                        if (J.valid)
                           {F.trigger("is-valid");
                           }
                        else 
                           {
                           F.trigger("is-invalid", J.msg);
                           }
                       }
                   , beforeSend: null, complete: function()
                       {H();
                       }
                   });
                   }
                else 
                   {F.trigger("is-invalid", _("Should look like an email address"));
                   }
               }
            F.isSignupFormField(
            {validateWith: function(I)
               {if (isBlank(I))
                   {return _("Please enter your email address");
                   }
                else 
                   {if ( ! I.match(C))
                       {return _("Should look like an email address");
                       }
                   }
               }
           , allowInput:/[^\s]/});
            F.blur(function(I)
               {if (F.val() == "")
                   {F.trigger("show-info");
                    F.parents("tr:eq(0)").find(".label-box.info").hide();
                    F.removeClass("with-box");
                   }
                else 
                   {B();
                   }
               });
            F.bind("value-changed", B);
            F.bind("custom-validate", B);
           });
       };
   })(jQuery);
(function(A)
   {
   A.fn.isScreenNameField = function()
       {return this.each(function()
           {var M = A(this);
            var F = A("#signup_username_url");
            var E = A("#screen_name_info");
            var D = A("#avail_screenname_check_indicator");
            var O;
            var C;
            var I;
            var N = M.val();
            var G = N;
            var H = N != "";
            var Q =/[a-zA-Z0-9_]/;
           
            function K()
               {if (H)
                   {F.html(M.val());
                   }
               }
           
            function L()
               {M.trigger("show-info");
                E.hide();
                D.show();
               }
           
            function B()
               {E.show();
                D.hide();
               }
           
            function P()
               {G = O;
                jQuery.ajax( {type: "GET", url: "/users/username_available", data: 
                {username: O}, dataType: "json", success: function(R)
                   {if (C)
                       {var S = R.msg;
                        if (R.valid)
                           {M.trigger("is-valid");
                            F.removeClass("invalid").addClass("valid");
                           }
                        else 
                           {M.trigger("is-invalid", R.msg);
                           
                            F.addClass("invalid").removeClass("valid");
                           }
                       }
                   }
               , beforeSend: null, complete: function()
                   {clearTimeout(twttr.timeouts.availabilityTimeout);
                    B();
                   }
               });
               }
           
            function J(R)
               {O = M.val();
                clearTimeout(twttr.timeouts.availabilityTimeout);
                C = O.match(Q);
                if ( ! C)
                   {G = O;
                    B();
                    return;
                   }
                if (O == G)
                   {return;
                   }
                L();
                twttr.timeouts.availabilityTimeout = setTimeout(P, 2000);
               }
            M.isSignupFormField(
            {validateWith: function(R)
               {if (isBlank(R))
                   {return _("Please enter a user name");
                   }
                else 
                   {P();
                   }
               }
           , allowInput: Q});
            M.keyup(function(R)
               {if (jQuery.inArray(R.keyCode,[16, 17, 18, 20, 27, 33, 34, 35, 37, 38, 39, 40, 144]) == - 1)
                   {if (M.val() != "")
                       {H = true;
                       }
                    else 
                       {M.trigger("show-info");
                       }
                    K();
                    J();
                   }
               });
            M.bind("value-changed", P);
            M.bind("custom-validate", P);
           });
       };
   })(jQuery);
(function(A)
   {
   A.fn.isSignupFormField = function(B)
       {return this.each(function()
           {var K = A(this);
            var U = K.parents("tr:eq(0)");
            var T = this;
            var F = U.find(".label-box");
            var D = U.find(".label-box.info");
            var V = U.find(".label-box.good");
            var L = U.find(".label-box.error");
            var E = D;
            var Q = false;
            var G = K.val();
            var J = G != "";
            var I = K.parent("div.fieldWithErrors").length > 0;
            var P = B.validateWith;
            var N = B.allowInput;
           
            function M()
               {E.show();
                K.addClass("with-box");
               }
           
            function X()
               {if ( ! Q)
                   {E.hide();
                    K.removeClass("with-box");
                   }
               }
           
            function W(a)
               {E.hide();
                E = a;
                M();
               }
           
            function H()
               {var a = K.val();
                J = (a != G);
                if (J)
                   {I = false;
                   }
                G = a;
                return J;
               }
           
            function R()
               {Q = true;
                W(D);
               }
           
            function Z()
               {Q = true;
                W(L);
               }
           
            function Y()
               {Q = true;
                W(V);
               }
           
            function S(a)
               {return P ? P(a): true;
               }
           
            function O()
               {if (I)
                   {K.trigger("is-invalid");
                   }
                else 
                   {if (J)
                       {var a = S(K.val());
                        if (a === true)
                           {K.trigger("is-valid");
                           }
                        else 
                           {if (typeof (a) == "string")
                               {K.trigger("is-invalid", a);
                               }
                           }
                       }
                   }
               }
           
            function C()
               {if (I)
                   {K.trigger("is-invalid");
                   }
                else 
                   {K.trigger("is-valid");
                   }
               }
            K.focus(M);
            K.blur(function()
               {if (H())
                   {K.trigger("value-changed");
                    O();
                   }
                X();
               });
            K.bind("is-valid", Y);
            K.bind("is-invalid", Z);
            K.bind("show-info", R);
            K.bind("validate", O);
            K.bind("align-validation", C);
            K.bind("is-invalid", function(b, a)
               {if (a)
                   {L.html(a);
                   }
               });
            if (N)
               {K.keypress(function(b)
                   {var a = b.which;
                    var c = String.fromCharCode(a);
                    return ! ! (a == 0 || a == 8 || a == 9 || a == 13 || c.match(N));
                   });
               }
            F.hide();
           });
       };
   })(jQuery);