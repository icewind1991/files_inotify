# files_inotify

Adds support detecting changes in local external storages with occ files_external:notify

## Usage

Find the id of the external storage that should be checked

```
occ files_external:list

+----------+-------------+------------+-----------------------+------------------------+------------+------------------+-------------------+
| Mount ID | Mount Point | Storage    | Authentication Type   | Configuration          | Options    | Applicable Users | Applicable Groups |
+----------+-------------+------------+-----------------------+------------------------+------------+------------------+-------------------+
| 5        | /test       | Local      | None                  | datadir: "....."       |            |                  |                   |
+----------+-------------+------------+-----------------------+------------------------+------------+------------------+-------------------+

```

Run the filesystem watch

```
occ files_external:notify -v 5
```

## Scalability notes

Due to the nature of `inotify` the memory requirements of listening for changes 
scales linearly with the number of folders in the storage.

Additionally it's required to configure `fs.inotify.max_user_watches` on the server
to be higher than the total number of folders being watched.
