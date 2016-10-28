# Change Log


## 0.5.0 - 2015-12-31

### Changed

- Updated dependencies to Tactician 1.0


## 0.4.1 - 2015-06-05

### Added

- `QueueableCommand` interface to ease registering receivers in Bernard routers
- `QueueCommand` to ease passing commands to Bernard which does not implement `Bernard\Message` by wrapping them

### Changed

- `QueuedCommand` is now final


## 0.4.0 - 2015-05-08

### Changed

- Updated dependencies to Tactician 0.6


## 0.3.0 - 2015-03-30

### Changed

- The `Command` interface from Tactician is no longer required

### Removed

- `QueueableCommand` interface is not needed anymore


## 0.2.0 - 2015-03-17

### Added

- `*BusReceivers` to be added to Bernard's core routers

### Changed

- Use a `Producer` instead of a specific `Queue` (queue name can be guessed from the command)

### Removed

- Custom `Router` implementation


## 0.1.0 - 2015-02-19

### Added

- Initial release
