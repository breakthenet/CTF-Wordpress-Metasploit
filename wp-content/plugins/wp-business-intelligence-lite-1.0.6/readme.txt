=== WP Business Intelligence Lite ===
Contributors: calberti
Donate link: http://www.wpbusinessintelligence.com/contact-us/
Tags: charts, tables, d3, line chart, pie chart, bar chart, donut chart, nvd3, data analytics, business intelligence, bi, reporting
Requires at least: 3.4
Tested up to: 3.7.1
Stable tag: 1.0.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Dynamic web charts and tables for your site! Connect to your live WordPress instance DB to retrieve data in real-time and update charts and tables!

== Description ==
Adding charts and tables to your web site has never been that easy. WP Business Intelligence Lite transforms your WordPress platform in a reporting tool with responsive charts and tables. Charts are powered by [D3](http://d3js.org), a powerful JavaScript library for manipulating documents based on data. Tables are powered by [DataTables](http://datatables.net) and provide sorting, filtering and dynamic paging by default. With a little coding you can implement the [DataTables API](http://datatables.net/api) and add the advanced features you need.
The admin interface lets you create SQL queries to retrieve data from the DB. Once you have created at least one query that correctly retrieves data from your DB, you can define the type of chart (bar, (multi)line, pie) or table to be used to display them. A simple shortcode embeds the chart or table in any post or page. Each page refresh retrieves the data from the DB so that the information in the chart or table is always up-to-date.

WARNING: this plugin is the WP Business Intelligence core. In order to get full advantages from WP Business Intelligence, you can get WP Business Intelligence Pro or Enterprise together with the TinyMCE editor's extensions from the [WP Business Intelligence web site](http://www.wpbusinessintelligence.com)

Useful information can be found on the [WP Business Intelligence Support Portal](http://www.wpbusinessintelligence.com/support)

[WP Business Intelligence Showcase](http://www.wpbusinessintelligence.com/showcase)

[WP Business Intelligence FAQ](http://www.wpbusinessintelligence.com/support/wp-business-intelligence-faq/)

WP Business Intelligence uses NVD3 charts; in order to know more about NVD3 please visit [the project's page](http://nvd3.org/)

Please take one minute to [send us a feedback](http://www.wpbusinessintelligence.com/contact-us/)

= Features =

1. Live connection to your WordPress DB via custom SQL queries
2. Responsive charts/tables
3. Dynamically filter data to be displayed in the chart
4. Works in Chrome, Firefox, IE10
5. Customize your charts (data precision, labels, colors, etc.)
6. Charts based on D3 via [NVD3](http://nvd3.org/)

== Installation ==

1. Upload the uncompressed folder `wp-business-intelligence-lite` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

OR

1. Upload the wp-business-intelligence-lite.zip file via the 'Plugins->Add New' page of your WordPress dashboard
2. Activate the plugin through the 'Plugins' menu in WordPress

A detailed installation guide is available on the [WP Business Intelligence Support Portal](http://www.wpbusinessintelligence.com/support/wp-business-intelligence-faq/)

== Changelog ==

= 1.0 =
* First beta release
= 1.0.1 =
* Fixes on JS inclusion and icon chart
= 1.0.2 =
* First integration of "DataTables" tables
= 1.0.3 =
* Code was cleaned up to remove some warnings
= 1.0.4 =
* Bug fix with queries pagination
= 1.0.5 =
* TinyMCE button registration warning fixed.
* Donut chart added
* Version 1.1.13 of NVD3 integrated
= 1.0.6 =
* Added configurable currency to line and bar
* Renamed button registration function to avoid conflicts with other themes
== Frequently Asked Questions == 

In order to get a full overview about WP Business Intelligence, please visit [the official documentation page](http://www.wpbusinessintelligence.com/support/wp-business-intelligence-faq/)

### How do I create a new chart? ###
The steps required to create a new chart are:
1. create the SQL query that retrieves the data in the desired format as a table
2. select the chart type that better fits your data
3. define chart parameters such as: axis precision, labels names, chart name, colors and save it
4. insert the chart in your post/page with the following shortcode:

<pre>[wpbusinessintelligence id="11" type="chart" iframe="n" ]Any text (chart name?)[/wpbusinessintelligence]</pre>

### How does the chart retrieves data? ###
Data are retrieved at each page refresh with a SQL query on your live DB. So they are always up-to-date!

### How do they work? ###
The charts are powered by [D3](http://d3js.org), a powerful JavaScript library for manipulating documents based on data.
We are trying to wrap as many D3 charts as possible in WP Business intelligence. [Have a look here for more info!](http://www.wpbusinessintelligence.com)

### How do I extend the default DataTables features? ###
In order to add more Datatables features you will have to edit the "table.tpl" file located in the /templates/views directory.
At the very top of the file you will find the table initialisation call with the default options. You will have to edit this code in compliance with the [Datatables API](http://datatables.net/api).

== Upgrade Notice == 

= 1.0.1 =
Bug fix on JS inclusion that caused an error at plugin activation

= 1.0.2 =
Tables are integrated with the DataTables jQuery plugin

= 1.0.3 =
Warnings in Debug mode are removed.

= 1.0.6 =
A new column to the charts_view table is added

== Screenshots ==
1. [Create and test a query (click to enlarge)](http://www.wpbusinessintelligence.com/wp-content/uploads/assets/screenshot-1.png)
2. [Create and test a table view (click to enlarge)](http://www.wpbusinessintelligence.com/wp-content/uploads/assets/screenshot-2.png)
3. [Create and test a chart view (click to enlarge)](http://www.wpbusinessintelligence.com/wp-content/uploads/assets/screenshot-3.png)
4. [A sample dashboard (click to enlarge)](http://www.wpbusinessintelligence.com/wp-content/uploads/assets/screenshot-4.png)
5. [Insert a chart or table in a page/post (click to enlarge)](http://www.wpbusinessintelligence.com/wp-content/uploads/assets/screenshot-5.png)