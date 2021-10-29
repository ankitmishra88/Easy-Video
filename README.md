# Easy-Video
## Instruction to use the plugin

- Step 1 - Install and activate the plugin
- Step 2 - You'll see two new admin menu EV Import and Videos, Go to EV Import>API Key
- Step 3 - Get the API Key from Google Console for Youtube Data API V3, and paste it there ([Go to official documentation](https://developers.google.com/youtube/v3/getting-started))
- Step 4 - Go to EV Import> Put the Channel ID there (If Channel URL is: https://www.youtube.com/channel/UCq-Fj5jknLsUf-MWSy4_brA, Channel ID is UCq-Fj5jknLsUf-MWSy4_brA)

- Step 5 - Click On Fetch > You will see, how many videos have been fetched

## Developer Docs and Further Development

### Further Improvements that Can be done

#### Most Important
Youtube Data API returns results in paged format, assume if a channel contains 1000 videos, and in each request it returns 50 results, so you will have different next page token with each result, to fetch total 20 pages. Currently the plugin hasn't paging functionality available.

### Other Improvements

 1. Currently when you import, we put the ChannelId only, This can be made more easy to use by adding some functionality and check, so it works with channel URL also(It can get the id from channel url also).
 2. UI of Single Video Page can be improved
 3. Make plugin translatable
 4. Add some required actions/filters to make plugin extendible by some other developers to extend the functionality for their own purpose, without changing the plugin

