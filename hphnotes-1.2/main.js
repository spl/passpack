// HPHnotes - main javascript file


notes = new Passpack.static({

	_init: function () {
	// browser history loop to avoid broken back button:
		$.historyInit(function(){});
		for (var j=10;j>=0;j--) $.historyLoad(j);
	},
	
	ajax: function (pars,callback) {
		// shortcut function to launch XMLHttpRequest call:
		$.ajax({url:"hphnotes.php",type:"POST",data:pars,complete:callback});
	},
	
	start: function () {
		// writes the form on screen
		$("#intro").show();
		$("#wrapper").html("").append(
			dbIsOk
			? Q("DIV",{},
				Q("P",{},
					"Create an account to access your note.",
					Q("BR"),
					Q("I","If you've already created an account, just leave the \"retype\" filed blank to login.")
				),
				Q("P",{},
					Q("FORM",{},
						Q("LABEL",{'for':"userid"},"Userid"),
						Q("INPUT",{id:"userid"}),
						Q("BR"),
						Q("LABEL",{'for':"password"},"Password"),
						Q("INPUT",{id:"password",type:"password"}),
						Q("BR"),
						Q("LABEL",{'for':"retype"},"(retype)"),
						Q("INPUT",{id:"retype",type:"password"}),
						Q("BR"),
						Q("SPAN",{id:"error"}),
						Q("BR"),
						Q("INPUT",{id:"ok",type:"submit",'class':"button",value:"Signin (Signup)"})
					).submit(function(){
						notes.check();
						return false;
					})
				) 
			)
			: Q("DIV",{},Q("P","Oops... database connection failed. Please, configure config.php."))
		);
		dbIsOk && $("#userid")[0].focus();
	},
	
	check: function () {
		$("#error").html("");
		// reads userid and password typed by user
		var userid = $("#userid").val();
		var password = $("#password").val();
		var retype = $("#retype").val();
		if (!userid || !password || (retype && password != retype)) $("#error").text("Oops, there is some error...");
		else {
			// call the server passing a base64 encoded userid and the hash of the password
			this.ajax(
				{
					// encode userid using Base64+ (to avoid charset problems)
					userid: Passpack.encode("Base64+",userid),
					
					// hash the password (server never know the password)
					passwordhash: Passpack.utils.hashx(password),
					
					// ask the server for a signup, if applicable
					signup: retype ? true : false
				},
				this.load
			);
			
			// set user and password properties
			this.userid = userid;
			this.password = password;
			// set the master key creating a 256-bit key concatenating the password
			this.masterkey = Passpack.utils.hashx(password+Passpack.utils.hashx(password,1,1),1,1);
		}
		return false;
	},
	
	load: function (response) {
		if (response && response.responseText) {
			var rt = Passpack.JSON.parse(response.responseText);
			if (rt.ok) notes.fill(rt.mynotes);
			else $("#error").text(rt.message);
			return;
		}
		$("#error").text("Oops, there is some server error...");
	},
	
	
	fill: function (mynotes) {
		$("#intro").hide();
		var note = mynotes != "-" 
			// decrypt notes using the master key derived from the password
			? Passpack.decode("AES",mynotes,notes.masterkey) 
			: "";
		$("#wrapper").html("").append(
			Q("P",{id:"hello"},
				"Hello ",
				Q("B",notes.userid),
				" | ",
				Q("A",{href:"#"},"signout")
				.click(function() {
					delete notes.userid;
					delete notes.password;
					delete notes.maskerkey;
					notes.start();
				})
			),
			Q("TEXTAREA",{id:"mynotes"},note)
			.css({height: ($(window).height()-180)+"px",width: ($(window).width()-210)+"px",}),
			Q("BR"),
			Q("INPUT",{id:"ok",type:"button",'class':"button",value:"Save my notes"})
			.click(function () {
				notes.ajax(
					{
						userid: Passpack.encode("Base64+",notes.userid),
						passwordhash: Passpack.utils.hashx(notes.password),
						
						// encrypt notes using the master key derived from the password
						mynotes: Passpack.encode("AES",$("#mynotes").val(),notes.masterkey)
					},
					notes.after
				);
			})
		);
	},
	
	after: function () {
		$("#hello").append(
			as = Q("SPAN",{id:"saved",'class':"red"},"Your notes had been saved")
		);
		$("#saved").fadeOut(2000,function(){$("#saved").remove()});		
	} 

});

styles = {
	yellow: "deep black",
	black: "light yellow"
};

changeStyle = function (x) {
	$("#cssbase").attr({href:"css/"+x+".css"});
	$("#changestyle").text(styles[x]).click(function (){
		changeStyle(x=='black'?'yellow':'black');
	});
};

$(document).ready(function () {
	changeStyle("yellow");
	notes.start();
});


