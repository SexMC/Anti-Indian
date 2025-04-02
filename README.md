# AntiIndian

A PocketMine-MP plugin that automatically kicks players from India based on locale and IP-based country detection.

## Features

- Listens to `PlayerJoinEvent`
- Kicks players whose locale is one of the following:
  - `hi_IN` (Hindi - India)
  - `bn_IN` (Bengali - India)
  - `ta_IN` (Tamil - India)
- Performs an asynchronous IP-based geolocation check using `ip-api.com`
  - If the country code is `IN`, the player is kicked

## Code Overview

- **Main Class:** `SexMC\AntiIndian\Main`
- **Event Listener:** Handles player join
- **Async Task:** Queries the `ip-api.com` endpoint to determine country based on IP

## Usage

Place the plugin `.phar` into your `plugins/` directory and restart your PocketMine-MP server.

## License

This repository is provided as-is, with no warranty. Usage is at your own risk.