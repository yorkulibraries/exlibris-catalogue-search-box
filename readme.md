# ExLibris Catalogue Discovery Search Box: Wordpress Plugin

## About
York University Libraries will be switching to ExLibris Alma/Primo Library Services Platform in Dec 2019. The need for replacing the search box arose, hence this widget-plugin and a way to help other members.

## Installation
### Git

1. cd to you /website-wp/wp-content/plugins directory
2. git clone 
3. login to wordpress backend -> Plugins -> ExLibris Catalogue Search Box -> Activate

### Download Zip
1. Download plugin from here as zip
2. login to wordpress backend -> Plugins -> Add new -> upload plugin -> select downloaded zip

## Setups
**Once installed**, 

For Page

1. Go to the landing page (Website-Backend->Pages->your-page)
2. Insert Wordpress 5.x Block - Widget
3. In the block select the ExLibris Search Box

For Widget

1. Widget area (appearences -> widgets -> Drag ExLibris to sidebar)

###Fields to fill


| **Title:** ||
---------------------- | -------------
| **Type** | Widget Title |
| **Default Value** | "" 
| **Where to find** | You Decide. This will show up above your the widget
| **Required** | No |

| **Discovery URL:** ||
---------------------- | -------------
| **Type** | Your Primo URL |
| **Default Value** | https://**\<your-institute-host-name>**.exlibrisgroup.com/discovery/search
| **Where to find** | ExLibris Support / Your Team Lead.
| **Required** | Yes |

| **Institution ID:** ||
---------------------- | -------------
| **Type** | Your Primo URL |
| **Default Value** |  01XXXXXX:XXXXXXX |
| **Where to find** | ```Configuration``` -> ```Discovery``` -> ```Display Configuration``` -> ```Configure Views``` under the **code** heading. |
| **Required** | Yes |

| **Tab Code:** ||
---------------------- | -------------
| **Type** | tab\_code |
| **Default Value** | Everything |
| **Where to find** | ```Configuration``` -> ```Discovery``` -> ```Display Configuration``` -> ```Configure Views``` -> ```Edit``` -> ```Search Profile Slots``` (tab) under the **code** heading.
| **Required** | Yes |

| **Search Scope:** ||
---------------------- | -------------
| **Type** | scope name|
| **Default Value** | MyInst_and_CI |
| **Where to find** | ```Configuration``` -> ```Discovery``` -> ```Display Configuration``` -> ```Configure Views``` -> ```Edit``` -> ```Search Profile Slots``` (tab) under the **search profiles** heading.
| **Required** | Yes |

| **Unique Primo Query Value:** ||
---------------------- | -------------
| **Type** | If you wish to have multiple search boxes on a page/widgets|
| **Default Value** | Automatically takes the widget name + id as the unique value |
| **Where to find** | Leave default. If you wish to change it, up to you.
| **Required** | Yes |

| **Search Box Placeholder:** ||
---------------------- | -------------
| **Type** | Text |
| **Default Value** | "" |
| **Where to find** | The placehoder text that shows up in the search box
| **Required** | No |

| **Custom CSS Class:** ||
---------------------- | -------------
| **Type** | CSS Styles|
| **Default Value** | "" |
| **Where to find** | This will add a class to div above main .search-container. You can also edit the styles directly in your css and get the class name from Browser Inspector (Right click on page -> Inspect).
| **Required** | No |

## TODO
* Internationalization 
* Look into Advanced Search Box

## References:

* [Primo VE Creating a Search Box](https://knowledge.exlibrisgroup.com/Primo/Product_Documentation/020Primo_VE/008Primo_VE_User_Interface/010Primo_VE_Customization_-_Best_Practices#Creating_a_Search_Box_With_Deep_Links_to_Primo_VE)




