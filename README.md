# Unicode Emoji v14 Parser with Pure PHP

Currently 4440+ emojis

# 👋🏻👨🏻‍🦱🧜🏻🏄🏽‍♀️⛹🏽‍♂️🛀🏾🇨🇭🇹🇷🇩🇪🍖🦄🐳🌵 and more

Parse operations with pure PHP over Unicode v14 emojis

See full list here:

- https://unicode.org/Public/emoji/14.0/emoji-test.txt

Help

- http://www.unicode.org/reports/tr51
- https://unicode.org/emoji/charts/index.html

---

## Usage

### Initialize an object

```
$e = new \UnicodeEmoji\Core\Parser();
//true: json, false: php array
$giveMeJson = true;
```

### Get all emojis

```
$e->getEmojis($giveMeJson);

[0] => Array
    (
        [codes] => Array
            (
                [0] => 1F600
            )

        [symbol] => 😀
        [e] => E1.0
        [name] => grinning face
        [variableName] => grinningFace
        [mainGroup] => Array
            (
                [name] => Smileys & Emotion
                [slug] => smileys-emotion
            )

        [subGroup] => Array
            (
                [name] => face-smiling
                [slug] => face-smiling
            )

    )
[1]..
[2]..

```

### Get main emoji groups

```
$e->getMainGroups($giveMeJson)

[0] => Array
    (
        [name] => Smileys & Emotion
        [slug] => smileys-emotion
    )

[1] => Array
    (
        [name] => People & Body
        [slug] => people-body
    )

```

### Get sub emoji groups

```
$e->getMainGroups($giveMeJson)

[0] => Array
    (
        [name] => face-smiling
        [slug] => face-smiling
    )

[1] => Array
    (
        [name] => face-affection
        [slug] => face-affection
    )


```

If you're using Docker you can run demo project with it. Stack is PHP8 and Apache. (Docker part is optional)

```
docker compose up
```
Then visit http://localhost:8000

### About Emoji

https://home.unicode.org/emoji/about-emoji/

`Emoji are pictographs (pictorial symbols) that are typically presented in a colorful form and used inline in text. They represent things such as faces, weather, vehicles and buildings, food and drink, animals and plants, or icons that represent emotions, feelings, or activities. To the computer they are simply another character, but people send each other billions of emoji everyday to express love, thanks, congratulations, or any number of a growing set of ideas.`

### Unicode FAQ

https://home.unicode.org/basic-info/faq/

### Terms for Unicode

For the general privacy policy governing access to unicode.org, see the Unicode Privacy Policy.

Terms of Use for Unicode Data Files
https://www.unicode.org/license.html

## License

MIT © Joel Hakkı Konu 2021
