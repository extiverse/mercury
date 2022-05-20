import app from 'flarum/admin/app';
import ExtensionPage from 'flarum/components/ExtensionPage';
import LoadingIndicator from 'flarum/components/LoadingIndicator';
import icon from 'flarum/helpers/icon';
import classList from 'flarum/utils/classList';

export default class ExtensionsUpdatesPage extends ExtensionPage {
    oninit(vnode) {
        super.oninit(vnode);

        this.token = app.data.settings['extiverse-mercury.token'] || null;
        this.loading = true;
        this.updates = [];

        if (this.token) {
            app.request({
                method: 'GET',
                url: app.forum.attribute('apiUrl') + '/extiverse/mercury/extension-updates'
            }).then((response) => {
                this.updates = response;

                this.loading = false;

                m.redraw();
            });
        } else {
            this.loading = false;
        }
    }

    className() {
        return 'Extiverse Mercury ExtensionUpdates--Page';
    }

    content() {
        if (this.loading) {
            return <LoadingIndicator/>;
        }

        return super.content();
    }

    sections() {
        let sections = super.sections();

        sections.remove('permissions');

        sections.add('extension-updates', this.extensionUpdates());

        return sections;
    }

    extensionUpdates() {
        if (this.loading) return (<div />);

        return (
            <div className="container UserListPage">
                <div className="UserListPage-grid UserListPage-grid--loaded" style="--columns: 4">
                    <div aria-rowindex={1} aria-colindex={1} className="UserListPage-grid-header">{app.translator.trans('extiverse-mercury.admin.extension-updates-page.extension-name')}</div>
                    <div aria-rowindex={1} aria-colindex={2} className="UserListPage-grid-header">{app.translator.trans('extiverse-mercury.admin.extension-updates-page.installed-version')}</div>
                    <div aria-rowindex={1} aria-colindex={3} className="UserListPage-grid-header">{app.translator.trans('extiverse-mercury.admin.extension-updates-page.highest-version')}</div>
                    <div aria-rowindex={1} aria-colindex={4} className="UserListPage-grid-header">{app.translator.trans('extiverse-mercury.admin.extension-updates-page.extension-is-up-to-date')}</div>
                    {this.updates.map((update, i) => {
                        return this.extensionUpdateItem(update, i);
                    })}
                </div>
            </div>
        );
    }
    extensionUpdateItem(update, i) {
        const updateClass = update['needs-update'] ? 'update-available' : 'update-ok';
        const classes = classList(['UserListPage-grid-rowItem', i % 2 > 0 && 'UserListPage-grid-rowItem--shaded', updateClass]);

        return [
            <div className={classes} aria-rowindex={i + 2} aria-colindex={1}>{update['title']} <code>({update['name']})</code></div>,
            <div className={classes} aria-rowindex={i + 2} aria-colindex={2}>{update['current-version']}</div>,
            <div className={classes} aria-rowindex={i + 2} aria-colindex={3}>{update['highest-version']}</div>,
            <div className={'centered ' + classes} aria-rowindex={i + 2} aria-colindex={4}>{update['needs-update'] ? icon('fas fa-exclamation-triangle') : icon('fas fa-check')}</div>
        ];
    }
}
