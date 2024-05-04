# Where's That Station

![wheres that station](https://github.com/heliogoodbye/Wheres-That-Station/assets/105381685/c67a370e-a331-4017-a137-15f0b7df1eaf)

Nexstar Media Group has **200+** TV stations and is the largest local broadcaster in the United States. With that many stations in 100+ markets across the country, it can be difficult to keep track of where a station is located and the current time there, so I set forth to create a plugin to serve as a quick reference.

Intended for use on the internal Nexstar Newsroom website, **Where's that Station?** is a WordPress plugin designed to display the time zone and current time of a Nexstar TV station based on its call letters. It provides a shortcode `[wheres_that_station]` that users can embed in their WordPress posts or pages to easily access this functionality.

Here's how the plugin works:

1. **Shortcode Integration**: Users can insert the `[wheres_that_station]` shortcode into any post or page where they want to display the station finder form.

2. **Station Finder Form**: The plugin adds a styled form to the post or page content. This form includes an input field where users can enter the call letters of the TV station they want to find information about.

3. **AJAX Functionality**: When users submit the form, an AJAX request is triggered to fetch the time zone and current time of the specified TV station without reloading the page.

4. **Dynamic Content Display**: Once the AJAX request is successful, the plugin dynamically updates the content area with the time zone and current time information of the specified TV station.

5. **Backend Functionality**: Behind the scenes, the plugin contains a PHP function that handles the AJAX request and retrieves the time zone and current time data based on the provided call letters. This data is then returned to the frontend for display.

Overall, the plugin offers a convenient way for site visitors to quickly find out the time zone and current time of any Nexstar TV station by simply entering its call letters into a form on the internal Newsroom site.

---

## How to use Where's That Station?

To use the plugin on your WordPress site, follow these step-by-step instructions:

1. **Install the Plugin**:
   - Log in to your WordPress admin dashboard.
   - Navigate to the "Plugins" section and click on "Add New".
   - In the search bar, type "Where's that Station?" and press Enter.
   - Once you find the plugin in the search results, click on "Install Now" and then "Activate" to enable it on your site.

2. **Add the Shortcode to a Post or Page**:
   - Create a new post or page where you want to display the station finder form.
   - In the content editor, place your cursor where you want the form to appear.
   - Enter the shortcode `[wheres_that_station]` at that location.
   - Save or publish the post/page.

3. **View the Form on the Frontend**:
   - Visit the post or page where you added the shortcode.
   - You should see a form with an input field where you can enter the call letters of the Nexstar TV station you want to find information about.

4. **Enter TV Station Call Letters**:
   - In the input field of the form, type the call letters of the Nexstar TV station you're interested in. For example, you could enter "KXAN", "WGNO", "WKRN", etc.
   - Make sure to enter the correct call letters for the station you want to look up.

5. **Submit the Form**:
   - After entering the call letters, click on the submit button or press Enter.
   - The plugin will process your request and fetch the time zone and current time information for the specified TV station.

6. **View Time Zone and Current Time**:
   - Once the request is processed, the plugin will dynamically display the time zone and current time of the TV station you entered.
   - You should see this information displayed on the same page, below the form.
