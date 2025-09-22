# EventPro - Event Management System (MVC)

## Project Structure
This project has been refactored to follow the Model-View-Controller (MVC) architectural pattern.

## File Structure
```
Project1/
├── Index.php              # Front controller (all requests go through here)
├── .htaccess             # URL rewriting rules
├── app/
│   ├── controller/
│   │   ├── Controller.php      # Base controller class
│   │   ├── UserController.php  # Handles user auth & dashboard
│   │   ├── EventController.php # Handles event management
│   │   ├── VenueController.php # Handles venue management
│   │   └── AdminController.php # Admin-specific functionality
│   ├── model/
│   │   ├── Model.php           # Base model class
│   │   ├── UserModel.php       # User data & authentication
│   │   ├── EventModel.php      # Event data management
│   │   └── VenueModel.php      # Venue data management
│   └── view/
│       ├── inc/
│       │   ├── header.php      # Common header
│       │   └── footer.php      # Common footer
│       ├── user/
│       │   ├── login.php       # Login page
│       │   ├── register.php    # Registration page
│       │   ├── dashboard.php   # User dashboard
│       │   └── settings.php    # User settings
│       ├── event/
│       │   └── list.php        # Events listing
│       ├── venue/
│       │   └── list.php        # Venues listing
│       └── admin/
│           └── dashboard.php   # Admin dashboard
└── public/
    ├── css/
    │   └── style.css          # Styles
    └── js/
        ├── dashboard.js       # Dashboard scripts
        ├── events.js          # Event management scripts
        └── venues.js          # Venue management scripts
```

## Routes
All routes follow the pattern: `Index.php?controller=NAME&action=METHOD`

### Public Routes (No login required)
- `Index.php?controller=user&action=login` - Login page
- `Index.php?controller=user&action=register` - Registration page

### User Routes (Login required)
- `Index.php?controller=user&action=dashboard` - User dashboard
- `Index.php?controller=user&action=settings` - User settings
- `Index.php?controller=user&action=logout` - Logout

### Event Routes
- `Index.php?controller=event&action=list` - List all events
- `Index.php?controller=event&action=create` - Create event (organizer/admin only)
- `Index.php?controller=event&action=view&id=X` - View event details

### Venue Routes
- `Index.php?controller=venue&action=list` - List all venues
- `Index.php?controller=venue&action=create` - Add venue (organizer/admin only)
- `Index.php?controller=venue&action=view&id=X` - View venue details

### Admin Routes (Admin role required)
- `Index.php?controller=admin&action=dashboard` - Admin dashboard
- `Index.php?controller=admin&action=users` - User management
- `Index.php?controller=admin&action=settings` - System settings

## Test Users (Hardcoded)
| Username | Password | Role | 
|----------|----------|------|
| admin | admin123 | admin |
| organizer | org123 | organizer |
| john | john123 | organizer |
| jane | jane123 | attendee |
| bob | bob123 | attendee |

## User Roles
1. **Admin** - Full system access, can manage users, events, and venues
2. **Organizer** - Can create and manage events, book venues
3. **Attendee** - Can browse events and venues, register for events

## How It Works
1. All requests go through `Index.php` (front controller)
2. The controller and action are determined from URL parameters
3. The appropriate controller is instantiated and method called
4. Controller loads model for data processing
5. Controller loads view for presentation
6. Views are wrapped with header and footer

## Original Files (Deprecated)
The following files are kept for reference but are no longer used:
- index.php (old login)
- home.php (old dashboard)
- events.php (old events page)
- venues.php (old venues page)
- settings.php (old settings)
- register.php (old registration)
- logout.php (old logout)

These have been replaced by the MVC structure.

## Running the Application
1. Place in your web server's document root
2. Access via: `http://localhost/Project1/Index.php`
3. Login with one of the test users above
