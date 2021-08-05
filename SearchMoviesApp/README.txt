Hi,

First of all, I want to say "Thank you" for giving me this opportunity.
And, It seems like there are a few problems with OMDB API. According to the document of API, Two different searches can be made by passing the different parameters to API Call.
One is "By ID or Title" and another one is "By Search".

It seems like only one result is returned if we search "By Title" and it doesn't accept "page" parameter which is used to determine how many results to return.

For example, http://www.omdbapi.com/?t=Iron+Man&apikey=5aa3a4bd

Making "By Search" API call returns multiple results. However, "Runtime" is not in the response ArrayList. So, I am displaying "Type" instead of "Runtime".

For example,http://www.omdbapi.com/?s=Iron+Man&r=json&apikey=5aa3a4bd.

To be safe, I wrote two versions of scripts (i.e getmovieList.php and getmatchMovie.php ). In getmovieList.php, it will be making "By Search" API call and  "By Title" search in getmatchMovie.php.
All you have to do is copy whatever script you want to run into index.php.

Thank
Kenneth
