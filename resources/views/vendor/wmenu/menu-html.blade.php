<?php $currentUrl = url()->current(); ?>
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link href="{{asset('vendor/harimayco-menu/style.css')}}" rel="stylesheet">
<div id="hwpwrap">
	<div class="custom-wp-admin wp-admin wp-core-ui js   menu-max-depth-0 nav-menus-php auto-fold admin-bar">
		<div id="wpwrap">
			<div id="wpcontent">
				<div id="wpbody">
					<div id="wpbody-content">
						<div class="wrap">
							<div id="nav-menus-frame">
								@if(request()->has('menu')  && !empty(request()->input("menu")))
								<div id="menu-settings-column" class="metabox-holder">
									<div class="clear"></div>
									<form id="nav-menu-meta" action="" class="nav-menu-meta" method="post" enctype="multipart/form-data">
										<div id="side-sortables" class="accordion-container">
											<ul class="outer-border">
												<li class="control-section accordion-section  open add-page" id="add-page">
													<h3 class="accordion-section-title hndle" tabindex="0"> Tambah Sub Menu <span class="screen-reader-text">Press return or enter to expand</span></h3>
													<div class="accordion-section-content ">
														<div class="inside">
															<div class="customlinkdiv" id="customlinkdiv">
																<p id="menu-item-url-wrap">
																	<label class="howto" for="custom-menu-item-url"> <span>URL</span>&nbsp;&nbsp;&nbsp;
																		<input id="custom-menu-item-url" name="url" type="text" class="menu-item-textbox " placeholder="url">
																	</label>
																</p>
																<p id="menu-item-name-wrap">
																	<label class="howto" for="custom-menu-item-name"> <span>Label</span>&nbsp;
																		<input id="custom-menu-item-name" name="label" type="text" class="regular-text menu-item-textbox input-with-default-title" title="Label menu">
																	</label>
																</p>
                                                                <p id="menu-item-name-wrap">
																	<label class="howto" for="custom-menu-item-name-en"> <span>Label An</span>&nbsp;
																		<input id="custom-menu-item-name-en" name="class" type="text" class="regular-text menu-item-textbox input-with-default-title" title="Label menu">
																	</label>
																</p>
																<p class="button-controls">
                                                                    <a style="color: #FFFF; float:right;" onclick="addcustommenu()" name="save_menu" id="save_menu_header" class="btn btn-primary">
                                                                        <span class="indicator-label">Tambah SubMenu</span>
                                                                        <span class="indicator-progress">Please wait...
                                                                            <span class="spinner" id="spincustomu"></span>
                                                                        </span>
                                                                    </a>
																</p>
															</div>
														</div>
													</div>
												</li>
											</ul>
										</div>
									</form>
								</div>
								@endif
								<div id="menu-management-liquid">
									<div id="menu-management">
										<form id="update-nav-menu" action="" method="post" enctype="multipart/form-data">
											<div class="menu-edit ">
												<div id="nav-menu-header">
													<div class="major-publishing-actions">
														<label class="menu-name-label howto open-label" for="menu-name">
                                                            <h5 style="margin: 5px;" class="hndle">@if(isset($indmenu)){{$indmenu->name}}@endif</h5>
															<input name="menu-name" readonly id="menu-name" type="hidden" class="menu-name regular-text menu-item-textbox" title="Enter menu name" value="@if(isset($indmenu)){{$indmenu->name}}@endif">
															<input type="hidden" id="idmenu" value="@if(isset($indmenu)){{$indmenu->id}}@endif" />
														</label>
													</div>
												</div>
												<div id="post-body">
													<div id="post-body-content">
														<ul class="menu ui-sortable" style="display: block;" id="menu-to-edit">
															@if(isset($menus))
															@foreach($menus as $m)
															<li id="menu-item-{{$m->id}}" class="menu-item menu-item-depth-{{$m->depth}} menu-item-page menu-item-edit-inactive pending" style="display: list-item;">
																<dl class="menu-item-bar">
																	<dt class="menu-item-handle" style="border-radius: 6px; background: #dee8e9;">
																		<span class="item-title"> <span class="menu-item-title"> <span id="menutitletemp_{{$m->id}}">{{$m->label}}</span> <span style="color: transparent;">|{{$m->id}}|</span> </span> <span class="is-submenu" style="@if($m->depth==0)display: none;@endif">Subelement</span> </span>
																		<span class="item-controls">
                                                                            <span class="item-type">Link</span>
                                                                            <span class="item-order hide-if-js">
                                                                                <a href="{{ $currentUrl }}?action=move-up-menu-item&menu-item={{$m->id}}&_wpnonce=8b3eb7ac44" class="item-move-up">
                                                                                    <abbr title="Move Up">↑</abbr>
                                                                                </a> |
                                                                                <a href="{{ $currentUrl }}?action=move-down-menu-item&menu-item={{$m->id}}&_wpnonce=8b3eb7ac44" class="item-move-down">
                                                                                    <abbr title="Move Down">↓</abbr>
                                                                                </a>
                                                                            </span>
                                                                            <a class="item-edit" onclick="noReload(event);" id="edit-{{$m->id}}" title=" " href="{{ $currentUrl }}?edit-menu-item={{$m->id}}#menu-item-settings-{{$m->id}}"> </a>
                                                                        </span>
																	</dt>
																</dl>
																<div class="menu-item-settings" id="menu-item-settings-{{$m->id}}">
																	<input type="hidden" class="edit-menu-item-id" name="menuid_{{$m->id}}" value="{{$m->id}}" />
																	<p class="description description-thin">
																		<label for="edit-menu-item-title-{{$m->id}}"> Label
																			<br>
																			<input type="text" id="idlabelmenu_{{$m->id}}" class="widefat edit-menu-item-title" name="idlabelmenu_{{$m->id}}" value="{{$m->label}}">
																		</label>
																	</p>
                                                                    <p class="description description-thin">
																		<label for="edit-menu-item-class-{{$m->id}}"> Label En
																			<br>
																			<input type="text" id="clases_menu_{{$m->id}}" class="widefat edit-menu-item-class" name="class-{{$m->id}}" value="{{$m->class}}">
																		</label>
																	</p>
																	<p class="field-css-url description description-wide">
																		<label for="edit-menu-item-url-{{$m->id}}"> Url
																			<br>
																			<input type="text" id="url_menu_{{$m->id}}" class="widefat code edit-menu-item-url" id="url_menu_{{$m->id}}" value="{{$m->link}}">
																		</label>
																	</p>
																	<div class="menu-item-actions description-wide submitbox">
																		<a class="button button-danger item-delete submitdelete deletion" onclick="noReload(event);" id="delete-{{$m->id}}" href="{{ $currentUrl }}?action=delete-menu-item&menu-item={{$m->id}}&_wpnonce=2844002501">Hapus</a>
																		<span class="meta-sep hide-if-no-js"> | </span>
																		<a onclick="getmenus()" class="button button-primary updatemenu save_menu" id="update-{{$m->id}}" href="javascript:void(0)">Update</a>
																	</div>
																</div>
																<ul class="menu-item-transport"></ul>
															</li>
															@endforeach
															@endif
														</ul>
														<div class="menu-settings">
														</div>
													</div>
												</div>
											</div>
                                            <a style="color: #ffffff; float:right;" onclick="getmenus()" name="save_menu" id="save_menu_header" class="btn btn-primary save_menu">
                                                <span class="indicator-label">Save Changes</span>
                                                <span class="indicator-progress">Please wait...
                                                <span class="spinner" id="spincustomu2"></span></span>
                                            </a>
											<a href="{{ route('menu-management.index') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-secondary text-white">Cancel</a>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<script>
function noReload(e) {
    e.preventDefault();
}
</script>
