import "./style.scss"
import "./editor.scss"

const { registerBlockType } = wp.blocks
const { RichText } = wp.blockEditor

export default registerBlockType(
  'captainwp/aparte',
  {
    title: 'Aparté',
    description: 'Un bloc bleu pour une belle aparté',
    category: 'captain',
    icon: { background: '#48ADD8', foreground: "#fff", src: 'slides' },
    keywords: [],
    attributes: {
      title: {
        type: 'string',
        selector: '.aparte__title',
        default: 'Aparté: ',
      },
      content: {
        type: 'array',
        source: 'children',
        selector: '.aparte__content',
      },
    },
    edit: props => {

      const { attributes: { title, content }, setAttributes} = props

      return (
        <div className="wp-block-captainwp-aparte aparte">
          <RichText
            tagName="p"
            value={ title }
            className='aparte__title'
            onChange={ title => setAttributes( { title } ) }
  				/>

          <RichText
            tagName="div"
            multiline="p"
            placeholder="Contenu de l'apparté"
            value={ content }
            className='aparte__content'
            onChange={ content => setAttributes( { content } ) }
  				/>
        </div>
      )
    },
    save: props => {

      const { title, content } = props.attributes

      return (
        <div className="aparte">
          <p className="aparte__title">{ title }</p>
          <div className="aparte__content">{ content }</div>
        </div>
      )
    }
  }
)
