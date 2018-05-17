<?php

namespace Modules\Currency\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterCurrencySidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('workshop::workshop.title'), function (Group $group) {
            $group->item(trans('setting::settings.title.settings'), function (Item $item) {
                $item->icon('fa fa-cog');
                $item->weight(20);
                $item->authorize(
                );

                $item->item(trans('setting::settings.title.settings'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.setting.settings.index');
                    $item->route('admin.setting.settings.index');
                    $item->authorize(
                        $this->auth->hasAccess('setting.settings.index')
                    );
                });

                $item->item(trans('currency::currencies.title.currency rate'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.currency.currency.create');
                    $item->route('admin.currency.currency.index');
                    $item->authorize(
                        $this->auth->hasAccess('currency.currencies.index')
                    );
                });

                $item->item(trans('currency::currencysymbols.title.currencysymbols'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.currency.currencysymbol.create');
                    $item->route('admin.currency.currencysymbol.index');
                    $item->authorize(
                        $this->auth->hasAccess('currency.currencysymbols.index')
                    );
                });

            });
        });

        return $menu;

//        $menu->group(trans('core::sidebar.content'), function (Group $group) {
//            $group->item(trans('currency::currencies.title.currencies'), function (Item $item) {
//                $item->icon('fa fa-copy');
//                $item->weight(10);
//                $item->authorize(
//                     /* append */
//                );
//                $item->item(trans('currency::currencies.title.currencies'), function (Item $item) {
//                    $item->icon('fa fa-copy');
//                    $item->weight(0);
//                    $item->append('admin.currency.currency.create');
//                    $item->route('admin.currency.currency.index');
//                    $item->authorize(
//                        $this->auth->hasAccess('currency.currencies.index')
//                    );
//                });

// append

//
//            });
//        });
//
//        return $menu;
    }
}
