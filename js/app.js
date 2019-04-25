(function (Drupal, drupalSettings) {

    Drupal.behaviors.mathLexParse = {
        attach(context) {
            // Prepare the component.
            class MathComponent extends React.Component {

                // Retreive the result from formatter class.
                render() {
                    return (
                        <div>
                            <div className={'formula'}>{this.props.label_formula} : {this.props.formula}</div>
                            <div className={'result-calculate'}> {this.props.label_result} : {this.props.calculation}</div>
                        </div>
                    );
                }
            }

            // Render the result.
            ReactDOM.render(
                <MathComponent
                    label_formula={drupalSettings.results.label_formula}
                    formula={drupalSettings.results.formula}
                    label_result={drupalSettings.results.label_result}
                    calculation={drupalSettings.results.calculation}
                />,
                document.getElementById('result-mathematical-lexer-parser')
            );
        },
    };
})(Drupal, drupalSettings);