# TwitchAutomator

*Note that this thing is written without a framework or any real standards, so the code is pretty messy. Might refactor it one day with html templates and such.*

1. Install dependencies with composer.

2. Install utilities with pip, see below

3. Configure using the `config.json` file in the `config` directory.

4. Visit `sub.php` in your web browser to check that subscribing to the webhooks work. Make it automatic with a cronjob using wget/curl later. Check `subs.php` for subscription status. **This thing requires a public facing webserver.**

*One high-profile streamer VOD of 10 hours is about 30-50GB.*

## Main requirements
- PHP 7+
- Python 3.6
    - Python 3.7+ for tcd support
- [pip](https://pypi.org/project/pip/)
- [Composer](https://getcomposer.org/)

### pip packages
- [streamlink](https://github.com/streamlink/streamlink) (required)
- [youtube-dl](https://github.com/ytdl-org/youtube-dl) (recommended)
- [tcd](https://pypi.org/project/tcd/) (optional)
- [pipenv](https://github.com/pypa/pipenv) (optional, experimental)


## Features
- Automatic VOD recording pretty much the second the stream goes live, instead of checking it every minute like many other scripts do
- Basic video cutter with chapter display for easy exporting
- Writes a [losslesscut](https://github.com/mifi/lossless-cut/) compatible csv file for the full VOD so you don't have to find all the games.
- Uses `ts` instead of `mp4` so if the stream or program crashes, the file won't be corrupted
- Can be set to automatically download the whole stream chat to a JSON file, to be used in my [twitch-vod-chat](https://github.com/MrBrax/twitch-vod-chat) webapp.

## Some config help

`bin_dir`

where streamlink, youtube-dl, and tcd is installed with python

---
`hook_callback`

full url of where the webhook from twitch should post to, ending with `hook.php`

e.g. `http://example.com/twitchautomator/hook.php`

---
`vods_to_keep`
`storage_per_streamer`

vods per streamer and gigabytes per streamer to keep at one time before removing the oldest ones

---
`download_chat`

automatically download vod chat after capturing is completed