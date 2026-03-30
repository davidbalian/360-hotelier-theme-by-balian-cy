<?php
/**
 * Writes hotelier-db-defaults.sync.php from the database (CLI only).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once dirname( __DIR__ ) . '/inc/class-hotelier-defaults-snapshot-builder.php';

/**
 * CLI entry: builds snapshot via Hotelier_Defaults_Snapshot_Builder and writes PHP file.
 */
final class Hotelier_Defaults_Sync_Runner {

	private string $theme_dir;

	private bool $dry_run;

	private bool $skip_attachment_ids;

	/** @var int|null */
	private $service_post_id;

	public function __construct( string $theme_dir, bool $dry_run, bool $skip_attachment_ids, ?int $service_post_id ) {
		$this->theme_dir           = $theme_dir;
		$this->dry_run             = $dry_run;
		$this->skip_attachment_ids = $skip_attachment_ids;
		$this->service_post_id     = $service_post_id;
	}

	public function run(): int {
		$sync_path = $this->theme_dir . '/inc/hotelier-db-defaults.sync.php';
		$builder   = new Hotelier_Defaults_Snapshot_Builder(
			$this->theme_dir,
			$this->skip_attachment_ids,
			$this->service_post_id
		);
		$data      = $builder->build();

		if ( $this->dry_run ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo "Dry run — would write: {$sync_path}\n";
			echo 'site_content keys: ' . count( $data['site_content'] ) . "\n";
			echo 'page_meta contexts: ' . count( $data['page_meta'] ) . "\n";
			return 0;
		}

		$this->write_sync_file( $sync_path, $data );
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo "Wrote {$sync_path}\n";
		return 0;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	private function write_sync_file( string $path, array $data ): void {
		$header  = "<?php\n";
		$header .= "/**\n";
		$header .= " * DB-synced defaults overrides (generated).\n";
		$header .= " *\n";
		$header .= " * Regenerate: WP admin → Settings → Site content → Download JSON export, or CLI: scripts/hotelier-sync-defaults-from-db.php\n";
		$header .= " * Do not edit by hand.\n";
		$header .= " *\n";
		$header .= " * @package 360-hotelier\n";
		$header .= " */\n\n";
		$header .= "if ( ! defined( 'ABSPATH' ) ) {\n\texit;\n}\n\n";
		$body    = 'return ' . var_export( $data, true ) . ";\n";
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
		if ( false === file_put_contents( $path, $header . $body ) ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			fwrite( STDERR, "Error: could not write {$path}\n" );
			exit( 1 );
		}
	}
}
