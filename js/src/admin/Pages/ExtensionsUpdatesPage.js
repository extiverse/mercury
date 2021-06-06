import ExtensionPage from 'flarum/components/ExtensionPage';
import LoadingIndicator from 'flarum/components/LoadingIndicator';

export default class ExtensionsUpdatesPage extends ExtensionPage {
    oninit(vnode) {
        super.oninit(vnode);

        this.loading = true;

        app.request('extiverse/mercury/updates').then((response) => {
            console.log(response);
            this.loading = false;

            m.redraw();
        });
    }
    content() {
        if (this.loading) {
            return <LoadingIndicator/>;
        }

        return (
            <div></div>
        );
    }
}
