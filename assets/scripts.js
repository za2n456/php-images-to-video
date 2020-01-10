var hashMapResults = {}; 
var numOfKeywords = 0; 
var doWork = false; 
var keywordsToQuery = new Array(); 
var keywordsToQueryIndex = 0; 
var queryflag = false; 

window.setInterval(DoJob, 750); 

function StartJob()
{
	if(doWork == false)
	{                
		hashMapResults = {}; 
		numOfKeywords = 0; 
		keywordsToQuery = new Array();
		keywordsToQueryIndex = 0; 
		
		hashMapResults[""] = 1; 
		hashMapResults[" "] = 1; 
		hashMapResults["  "] = 1; 
		
		var ks = $('#input').val().split("\n");
		var i = 0; 
		for(i = 0; i < ks.length; i++)
		{
			keywordsToQuery[keywordsToQuery.length] = ks[i];

			var j = 0; 
			for(j = 0; j < 26; j++)
			{
				var chr = String.fromCharCode(97 + j);
				var currentx = ks[i] + ' ' + chr; 
				keywordsToQuery[keywordsToQuery.length] = currentx; 
				hashMapResults[currentx] = 1;
			}
		}
		//document.getElementById("input").value = ''; 
		document.getElementById("input").value += "\r\n";
		
		doWork = true; 
		$('#startjob').val('Stop Scrape');
	}
	else
	{
		doWork = false; 
		alert("Stopped"); 
		$('#startjob').val('Start Scrape');
	}
}

function DoJob()
{
	if(doWork == true && queryflag == false)
	{
		if(keywordsToQueryIndex < keywordsToQuery.length)
		{
			var currentKw = keywordsToQuery[keywordsToQueryIndex]; 
			QueryKeyword(currentKw);
			keywordsToQueryIndex++; 
		}
		else 
		{
			if (numOfKeywords != 0)
			{
				alert("Done"); 
				doWork = false; 
				$('#startjob').val('Start Scrape');
			}
			else
			{
				keywordsToQueryIndex = 0; 
			}
		}
	}
}

function QueryKeyword(keyword)
{
	var querykeyword = keyword;
	//var querykeyword = encodeURIComponent(keyword); 
	var queryresult = ''; 
	queryflag = true; 
	
	$.ajax({
		url: "http://suggestqueries.google.com/complete/search",
		jsonp: "jsonp",
		dataType: "jsonp",
		data: {
		q: querykeyword,
		client: "chrome"
		},
		success: function(res) {
			var retList = res[1];
			
			var i = 0; 
			var sb = ''; 
			for(i = 0; i < retList.length; i++)
			{
				var currents = CleanVal(retList[i]); 
				if(hashMapResults[currents] != 1)
				{
					hashMapResults[currents] = 1; 
					sb = sb + CleanVal(retList[i]) + '\r\n';
					numOfKeywords++; 
					
					keywordsToQuery[keywordsToQuery.length] = currents; 
					
					var j = 0; 
					for(j = 0; j < 26; j++)
					{
						var chr = String.fromCharCode(97 + j);
						var currentx = currents + ' ' + chr; 
						keywordsToQuery[keywordsToQuery.length] = currentx; 
						hashMapResults[currentx] = 1;
					}
				}
			}
			$("#numofkeywords").html(numOfKeywords + " keyword scrapped.");
			document.getElementById("input").value += sb;
			var textarea = document.getElementById("input");
			textarea.scrollTop = textarea.scrollHeight;
			queryflag = false; 
		}
	});           
}

function CleanVal(input)
{       
	var val = input;
	val = val.replace("\\u003cb\\u003e", "");
	val = val.replace("\\u003c\\/b\\u003e", "");
	val = val.replace("\\u003c\\/b\\u003e", "");
	val = val.replace("\\u003cb\\u003e", "");
	val = val.replace("\\u003c\\/b\\u003e", "");
	val = val.replace("\\u003cb\\u003e", "");
	val = val.replace("\\u003cb\\u003e", "");
	val = val.replace("\\u003c\\/b\\u003e", "");
	val = val.replace("\\u0026amp;", "&");
	val = val.replace("\\u003cb\\u003e", "");
	val = val.replace("\\u0026", "");
	val = val.replace("\\u0026#39;", "'");
	val = val.replace("#39;", "'");
	val = val.replace("\\u003c\\/b\\u003e", "");
	val = val.replace("\\u2013", "2013");
	if (val.length > 4 && val.substring(0, 4) == "http") val = "";
	return val; 
}